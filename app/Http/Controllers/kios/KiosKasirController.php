<?php

namespace App\Http\Controllers\kios;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\customer\Customer;
use App\Models\kios\KiosAkunRD;
use App\Models\kios\KiosProduk;
use App\Models\kios\KiosSerialNumber;
use App\Models\kios\KiosTransaksi;
use App\Models\kios\KiosTransaksiDetail;
use App\Models\produk\ProdukSubJenis;
use App\Repositories\kios\KiosRepository;
use Carbon\Carbon;
use Exception;

use function PHPSTORM_META\type;

class KiosKasirController extends Controller
{
    public function __construct(private KiosRepository $suppKiosRepo){}

    public function index()
    {
        $user = auth()->user();
        $divisiName = $this->suppKiosRepo->getDivisi($user);
        $today = Carbon::now();
        $dueDate = $today->copy()->addMonth(3);
        $customerData = Customer::all();
        $akunRd = KiosAkunRD::all();
        $invoiceId = KiosTransaksi::latest()->value('id');

        return view('kios.kasir.index', [
            'title' => 'Kasir Kios',
            'active' => 'kasir-kios',
            'divisi' => $divisiName,
            'dropdown' => '',
            'dropdownShop' => '',
            'today' => $today,
            'duedate' => $dueDate,
            'customerdata' => $customerData,
            'akunrd' => $akunRd,
            'invoiceid' => $invoiceId,
        ]);
    }

    public function store(Request $request)
    {
        try{
            $userId = auth()->user()->id;
            $request->validate([
                'nama_customer' => 'required',
                'kasir_metode_pembayaran' => 'required',
                'kasir_sn' => 'required|array|min:1',
                'item_id' => 'required|array|min:1',
                'kasir_qty' => 'required|array|min:1',
                'kasir_harga' => 'required|array|min:1',
            ]);
            
            $kasirTanggal = Carbon::now()->format('d-m-Y H:i:s');
            $kasirCustomer = $request->input('nama_customer');
            $kasirMetodePembayaran = $request->input('kasir_metode_pembayaran');
            $kasirDiscount = $request->input('kasir_discount');
            $kasirTax = $request->input('kasir_tax');

            $kasirItem = $request->input('item_id');
            $kasirSN = $request->input('kasir_sn');
            $kasirQty = $request->input('kasir_qty');
            $kasirSrp = preg_replace("/[^0-9]/", "", $request->input('kasir_harga'));
            $totalHarga = 0;

            if(count(array_unique($kasirSN)) !== count($kasirSN)) {
                return back()->with('error', 'Serial Number tidak boleh ada yang sama.');
            }

            $transaksi = new KiosTransaksi();
            $transaksi->employee_id = $userId;
            $transaksi->customer_id = $kasirCustomer;
            $transaksi->metode_pembayaran = $kasirMetodePembayaran;
            $transaksi->discount = $kasirDiscount;
            $transaksi->tax = $kasirTax;
            $transaksi->tanggal_pembelian = $kasirTanggal;
            $transaksi->save();

            foreach($kasirItem as $index => $item) {
                $totalHarga += $kasirQty[$index] * $kasirSrp[$index];
                
                $detailTransaksi = new KiosTransaksiDetail();
                $detailTransaksi->kios_transaksi_id = $transaksi->id;
                $detailTransaksi->kios_produk_id = $item;
                $detailTransaksi->serial_number_id = $kasirSN[$index];
                $detailTransaksi->quantity = $kasirQty[$index];
                $detailTransaksi->save();

                KiosSerialNumber::find($kasirSN[$index])->update(['status' => 'Sold']);
            }

            $transaksi->total_harga = $totalHarga;
            $transaksi->save();

            return back()->with('success', 'Success Do Transaction.');

        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }

    }

    public function autocomplete()
    {
        $items = ProdukSubJenis::with('produkjenis')->get();
        return response()->json($items);
    }

    public function getSerialNumber($id)
    {
        $produkId = KiosProduk::where('sub_jenis_id', $id)->value('id');
        $dataProduk = KiosProduk::where('sub_jenis_id', $id)->value('srp');
        $dataSN = KiosSerialNumber::where('produk_id', $produkId)->where('status', 'Ready')->get();
        return response()->json(['data_sn' => $dataSN, 'data_produk' => $dataProduk]);
    }

    public function getCustomer($customerId)
    {
        $dataCustomer = Customer::where('id', $customerId)->get();
        return response()->json($dataCustomer);
    }

}
