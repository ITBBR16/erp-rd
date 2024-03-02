<?php

namespace App\Http\Controllers\kios;

use Exception;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\customer\Customer;
use App\Models\produk\ProdukJenis;
use App\Http\Controllers\Controller;
use App\Models\kios\KiosMarketplace;
use App\Models\kios\KiosOrderSecond;
use Illuminate\Support\Facades\Http;
use App\Models\produk\ProdukSubJenis;
use App\Models\kios\KiosQcProdukSecond;
use App\Models\produk\ProdukKelengkapan;
use App\Models\kios\KiosStatusPembayaran;
use App\Repositories\kios\KiosRepository;
use App\Models\ekspedisi\PengirimanEkspedisi;
use App\Models\kios\KiosMetodePembelianSecond;

class KiosShopSecondController extends Controller
{
    public function __construct(private KiosRepository $suppKiosRepo){}

    public function index()
    {
        $user = auth()->user();
        $divisiName = $this->suppKiosRepo->getDivisi($user);
        $metode_pembelian = KiosMetodePembelianSecond::all();
        $statusPembayaran = KiosStatusPembayaran::all();
        $customer = Customer::all();
        $marketplace = KiosMarketplace::all();
        $kiosProduk = ProdukJenis::with('subjenis.kelengkapans')->get();
        $kelengkapan = ProdukKelengkapan::all();
        $secondOrder = KiosOrderSecond::with('customer', 'subjenis.produkjenis', 'qcsecond.kelengkapans', 'statuspembayaran', 'buymetodesecond')->get();

        return view('kios.shop.index-second', [
            'title' => 'Shop Second',
            'active' => 'shop-second',
            'navActive' => 'product',
            'divisi' => $divisiName,
            'dropdown' => '',
            'dropdownShop' => true,
            'metodePembelian' => $metode_pembelian,
            'customer' => $customer,
            'produkKios' => $kiosProduk,
            'kelengkapan' => $kelengkapan,
            'statusPembayaran' => $statusPembayaran,
            'orderSecond' => $secondOrder,
            'marketplace' => $marketplace,
        ]);
    }

    public function store(Request $request) // Kirim Ke akuntan jika Online
    {
        $request->validate([
            'kelengkapan_second' => 'array',
            'quantity_second' => 'array',
        ]);
        
        try{
            $user = auth()->user();
            $divisiId = $user->divisi_id;

            $kelengkapanSecond = $request->input('kelengkapan_second');
            $tanggal = $request->input('tanggal_pembelian');
            $mpId = $request->input('metode_pembelian');
            $tanggalPembelian = Carbon::parse($tanggal)->format('d-m-Y');
            $biayaPengambilan = preg_replace("/[^0-9]/", "", $request->input('biaya_pengambilan'));
            $biayaOngkir = preg_replace("/[^0-9]/", "", $request->input('biaya_ongkir'));
            $qtySecond = $request->input('quantity_second');
            $qtyNotNull = array_filter($qtySecond, function ($item) {
                return $item !== null;
            });
            $inputStatus = $request->input('status_pembayaran');
            $statusBayar = ($inputStatus == 'Offline' || $inputStatus == 'Online Pending' ? 'Unpaid' : ($inputStatus == 'Online DP' ? 'DP' : 'Paid'));

            $comeFrom = $request->input('come_from');
            $customerInput = $request->input('customer');
            $asalId = $request->input('marketplace');

            $orderSecond = KiosOrderSecond::create([
                'come_from' => $comeFrom,
                'customer_id' => $customerInput,
                'asal_id' => $asalId,
                'metode_pembelian_id' => $mpId,
                'tanggal_pembelian' => $tanggalPembelian,
                'sub_jenis_id' => $request->input('jenis_drone_second'),
                'status_pembayaran' => $statusBayar,
                'biaya_pembelian' => $biayaPengambilan,
                'biaya_ongkir' => $biayaOngkir,
            ]);

            $metodePembelian = KiosMetodePembelianSecond::findOrFail($mpId)->metode_pembelian;
            if(strpos(strtolower($metodePembelian), 'online') === 0) {
                PengirimanEkspedisi::create([
                    'divisi_id' => $divisiId,
                    'order_id' => $orderSecond->id,
                    'status_order' => 'Second',
                    'status' => 'Unprocess',
                ]);
                $statusOrderSecond = 'Belum Dikirim';
            } else {
                $statusOrderSecond = 'Proses QC';
            }

            $orderSecond->status = $statusOrderSecond;
            $orderSecond->save();

            $qcOrderSecond = new KiosQcProdukSecond();
            $qcOrderSecond->order_second_id = $orderSecond->id;
            $qcOrderSecond->save();

            foreach($kelengkapanSecond as $index => $id) {
                for($i = 0; $i < $qtyNotNull[$index]; $i++ ) {
                    $qcOrderSecond->kelengkapans()->attach($id, ['status' => 'Not Ready']);
                }
            }

            return back()->with('success', 'Success Buat Order Belanja Second.');

        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }

    }

    public function validasisecond(Request $request, $id)
    {
        try {

            $user = auth()->user();
            $divisiId = $user->divisi_id;
            $divisi = $this->suppKiosRepo->getDivisi($user);
            $divisiName = $divisi->nama;
            $tanggal = Carbon::now();
            $tanggal->setTimezone('Asia/Jakarta');
            $formattedDate = $tanggal->format('d/m/Y H:i:s');
            $urlFinance = 'https://script.google.com/macros/s/AKfycbzBE9VL6syqbKmLYxur9vffg9uJiNdV-Nu8Vg-RL1aEE7U_0WP6vqzg09FOrlZJD1uTfg/exec';
                
            $dataFinance = [
                'tanggal' => $formattedDate,
                'divisi' => $divisiName,
                'no_transaksi' => 'KiosSecond-' . $id,
                'supplier_kios' => $request->input('supplier_kios'),
                'invoice' => $request->input('invoice'),
                'media_transaksi' => $request->input('media_transaksi_second'),
                'no_rek' => $request->input('no_rek'),
                'nama_akun' => $request->input('nama_akun'),
                'nilai_belanja' => $request->input('biaya_pembelian'),
                'ongkir' => $request->input('ongkir_second'),
                'pajak' => 0,
                'keterangan' => $request->input('keterangan'),
            ];
        
            $response = Http::post($urlFinance, $dataFinance);

            if ($response->successful()) {

                $kiosOrderSecond = KiosOrderSecond::findOrFail($id);
                $kiosOrderSecond->status_pembarayan = 'Waiting For Payment';
                $kiosOrderSecond->save();
                return back()->with('success', 'Success Request Payment.');

            } else {
                return back()->with('error', 'Something Went Wrong.');
            }

        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $qcSecond = KiosQcProdukSecond::findOrFail($id);
            $idOrderSecond = $qcSecond->order_second_id;

            KiosOrderSecond::findOrFail($idOrderSecond)->delete();

            $qcSecond->kelengkapans()->detach();
            $qcSecond->delete();

            return back()->with('success', 'Success Delete Order Second.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error deleting order: ' . $e->getMessage());
        }
    }

    public function getKelengkapanSecond($jenisId)
    {
        $idJenisProduk = ProdukSubJenis::where('id', $jenisId)->value('jenis_id');
        $subJenis = ProdukSubJenis::findOrFail($jenisId);
        return response()->json(['kelengkapans' => $subJenis->kelengkapans, 'idJenisProduk' => $idJenisProduk]);
    }

    public function getCustomerbyNomor($nomor)
    {
        $dataCustomer = Customer::where('no_telpon', $nomor)->get();
        return response()->json($dataCustomer);
    }

    public function getAdditionalKelengkapan($id)
    {
        $kelengkapanByProduk = ProdukKelengkapan::where('produk_jenis_id', $id)->get();
        return response()->json($kelengkapanByProduk);
    }

}
