<?php

namespace App\Http\Controllers\kios;

use Exception;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\kios\KiosPayment;
use App\Models\customer\Customer;
use App\Models\produk\ProdukJenis;
use Illuminate\Support\Facades\DB;
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
use App\Models\kios\KiosMetodePembayaranSecond;

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
        $kiosProduk = ProdukSubJenis::all();
        $kelengkapan = ProdukKelengkapan::all();
        $secondOrder = KiosOrderSecond::orderBy('created_at', 'desc')->get();

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

    public function store(Request $request)
    {
        $connectionKios = DB::connection('rumahdrone_kios');
        $connectionProduct = DB::connection('rumahdrone_produk');
        $connectionKios->beginTransaction();
        $connectionProduct->beginTransaction();
        try{
            $request->validate([
                'kelengkapan_second' => 'array',
                'quantity_second' => 'array',
            ]);
            $user = auth()->user();
            $divisiId = $user->divisi_id;
            $kelengkapanSecond = $request->input('kelengkapan_second');
            $tanggalPembelian = $request->input('tanggal_pembelian');
            $mpId = $request->input('metode_pembelian');
            $biayaPengambilan = preg_replace("/[^0-9]/", "", $request->input('biaya_pengambilan'));
            $biayaOngkir = ($request->input('biaya_ongkir') != '') ? preg_replace("/[^0-9]/", "", $request->input('biaya_ongkir')) : 0;
            $qtySecond = $request->input('quantity_second');
            $qtyNotNull = array_filter($qtySecond, function ($item) {
                return $item !== null;
            });
            $inputStatus = $request->input('status_pembayaran');
            $statusBayar = ($inputStatus == 'Online DP' ? 'DP' : 'Unpaid');
            
            $comeFrom = $request->input('come_from');
            $customerInput = $request->input('id_customer');
            $searchPayment = KiosMetodePembayaranSecond::where('customer_id', $customerInput)->latest()->first();
            $paymentCustomer = ($searchPayment !== null) ? $searchPayment->id : '';
            $findCustomer = Customer::findOrFail($customerInput);
            $customerName = $findCustomer->first_name . " " . $findCustomer->last_name;
            $asalId = $request->input('marketplace');
            $alasanJual = $request->input('alasan_jual');

            $orderSecond = KiosOrderSecond::create([
                'come_from' => $comeFrom,
                'customer_id' => $customerInput,
                'asal_id' => $asalId,
                'alasan_jual' => $alasanJual,
                'metode_pembelian_id' => $mpId,
                'tanggal_pembelian' => $tanggalPembelian,
                'sub_jenis_id' => $request->input('paket_penjualan_second'),
                'status_pembayaran' => $statusBayar,
                'biaya_pembelian' => $biayaPengambilan,
                'biaya_ongkir' => $biayaOngkir,
            ]);
            // Send data to api
            $apiUrl = "https://script.google.com/macros/s/AKfycbwFGLi6XLWUKPvxiEqC8jQDJtynpwZWoYTW4Gqc_M2smqiU_nNYyHlalYUq1_jaUlGQOQ/exec";
            $response = Http::post($apiUrl, [
                'statusOrder' => 'Bekas',
                'orderId' => 'S.' . $orderSecond->id,
                'supplier' => $customerName,
            ]);

            $linkDrive = json_decode($response->body(), true);
            $orderSecond->link_drive = $linkDrive[0];
            $orderSecond->save();

            $metodePembelian = KiosMetodePembelianSecond::findOrFail($mpId)->metode_pembelian;
            if(strpos(strtolower($metodePembelian), 'online') === 0) {
                PengirimanEkspedisi::create([
                    'divisi_id' => $divisiId,
                    'order_id' => $orderSecond->id,
                    'status_order' => 'Bekas',
                    'status' => 'Belum Dikirim',
                ]);
                $statusOrderSecond = 'Belum Dikirim';
            } else {
                $statusOrderSecond = 'Belum Terbayar';
            }

            $orderSecond->status = $statusOrderSecond;
            $orderSecond->save();

            $qcOrderSecond = KiosQcProdukSecond::create(['order_second_id' => $orderSecond->id]);

            foreach($kelengkapanSecond as $index => $id) {
                for($i = 0; $i < $qtyNotNull[$index]; $i++ ) {
                    $qcOrderSecond->kelengkapans()->attach($id, ['status' => 'Not Ready']);
                }
            }
            
            if($request->has('additional_kelengkapan_second')) {
                $additionalKelengkapan = $request->input('additional_kelengkapan_second');
                $jenisProdukId = $request->input('produk_jenis_id'); // ganti karna many to many
                $additionalQty = $request->input('additional_quantity_second');
                $type = ProdukJenis::findOrFail($jenisProdukId);
                $jenisKelengkapan = collect($additionalKelengkapan)->map(function ($jk) {
                    return ['kelengkapan' => ucwords(strtolower($jk))];
                });
                $kelengkapanBaru = $type->kelengkapans()->createMany($jenisKelengkapan->toArray());
                $kelengkapanBaruId = $kelengkapanBaru->pluck('id')->toArray();
                foreach($kelengkapanBaruId as $index => $idBaru) {
                    for($j = 0; $j < $additionalQty[$index]; $j++) {
                        $qcOrderSecond->kelengkapans()->attach($idBaru, ['status' => 'Not Ready']);
                    }
                }
            }

            $jenisPembayaran = ['Pembelian Barang'];

            if ($biayaOngkir > 0) {
                $jenisPembayaran[] = 'Ongkir';
            }

            $jenisPembayaranStr = implode(', ', $jenisPembayaran);
            $payment = new KiosPayment([
                'order_type' => 'Bekas',
                'order_id' => $orderSecond->id,
                'metode_pembayaran_id' => $paymentCustomer,
                'jenis_pembayaran' => $jenisPembayaranStr,
                'nilai' => $biayaPengambilan,
                'ongkir' => $biayaOngkir,
                'status' => 'Unpaid',
            ]);

            $payment->save();
            $connectionKios->commit();
            $connectionProduct->commit();
            return back()->with('success', 'Success Buat Order Belanja Second.');

        } catch (Exception $e) {
            $connectionKios->rollBack();
            $connectionProduct->rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    public function validasisecond(Request $request, $id)
    {
        $connectionKios = DB::connection('rumahdrone_kios');
        $connectionKios->beginTransaction();

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

                $connectionKios->commit();
                return back()->with('success', 'Success Request Payment.');

            } else {
                $connectionKios->rollBack();
                return back()->with('error', 'Something Went Wrong.');
            }

        } catch (Exception $e) {
            $connectionKios->rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $connectionKios = DB::connection('rumahdrone_kios');
        $connectionEkspedisi = DB::connection('rumahdrone_ekspedisi');
        $connectionKios->beginTransaction();
        $connectionEkspedisi->beginTransaction();

        try {
            $qcSecond = KiosQcProdukSecond::findOrFail($id);
            $idOrderSecond = $qcSecond->order_second_id;

            $cekEkspedisi = PengirimanEkspedisi::where('order_id', $idOrderSecond)
                                                ->where('status_order', 'Bekas')
                                                ->exists();

            if($cekEkspedisi) {
                PengirimanEkspedisi::where('order_id', $idOrderSecond)
                                    ->where('status_order', 'Bekas')
                                    ->delete();
            }

            KiosPayment::where('order_id', $idOrderSecond)
                        ->where('order_type', 'Bekas')
                        ->delete();
            KiosOrderSecond::findOrFail($idOrderSecond)->delete();

            $qcSecond->kelengkapans()->detach();
            $qcSecond->delete();

            $connectionKios->commit();
            $connectionEkspedisi->commit();
            return back()->with('success', 'Success Delete Order Second.');
        } catch (\Exception $e) {
            $connectionKios->rollBack();
            $connectionEkspedisi->rollBack();
            return back()->with('error', 'Error deleting order: ' . $e->getMessage());
        }
    }

    public function getCustomerbyNomor($nomor)
    {
        $dataCustomer = Customer::where('no_telpon', $nomor)->get();
        return response()->json($dataCustomer);
    }

    public function getKelengkapanSecond($id)
    {
        $searchSub = ProdukSubJenis::find($id);
        $kelengkapans = $searchSub->allKelengkapans();

        return $kelengkapans;
    }

}
