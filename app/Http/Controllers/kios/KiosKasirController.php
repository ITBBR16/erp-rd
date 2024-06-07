<?php

namespace App\Http\Controllers\kios;

use Exception;
use Carbon\Carbon;
use Dompdf\Dompdf;
use Dompdf\Options;
use Barryvdh\DomPDF\PDF;
use Illuminate\Http\Request;
use App\Models\kios\KiosAkunRD;
use App\Models\kios\KiosProduk;
use App\Models\customer\Customer;
use App\Models\kios\KiosTransaksi;
use App\Http\Controllers\Controller;
use App\Models\kios\KiosProdukSecond;
use App\Models\kios\KiosSerialNumber;
use App\Models\kios\KiosTransaksiDetail;
use App\Repositories\kios\KiosRepository;
use Illuminate\Support\Facades\Http;

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
            'navActive' => 'kasir',
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
                'jenis_transaksi' => 'required|array|min:1',
                'kasir_sn' => 'required|array|min:1',
                'item_id' => 'required|array|min:1',
                'kasir_harga' => 'required|array|min:1',
            ]);
            
            $kasirOngkir = $request->input('kasir_ongkir');
            $kasirCustomer = $request->input('nama_customer');
            $kasirMetodePembayaran = $request->input('kasir_metode_pembayaran');
            $kasirDiscount = preg_replace("/[^0-9]/", "", $request->input('kasir_discount'));
            $kasirTax = $request->input('kasir_tax');

            $kasirJenisTransaksi = $request->input('jenis_transaksi');
            $kasirItem = $request->input('item_id');
            $kasirSN = $request->input('kasir_sn');
            $kasirSrp = preg_replace("/[^0-9]/", "", $request->input('kasir_harga'));
            $totalHarga = 0;

            if(count(array_unique($kasirSN)) !== count($kasirSN)) {
                return back()->with('error', 'Serial Number tidak boleh ada yang sama.');
            }

            $transaksi = new KiosTransaksi();
            $transaksi->employee_id = $userId;
            $transaksi->customer_id = $kasirCustomer;
            $transaksi->metode_pembayaran = $kasirMetodePembayaran;
            $transaksi->ongkir = $kasirOngkir;
            $transaksi->discount = $kasirDiscount;
            $transaksi->tax = $kasirTax;
            $transaksi->save();

            foreach($kasirItem as $index => $item) {
                $totalHarga += $kasirSrp[$index];
                
                $detailTransaksi = new KiosTransaksiDetail();
                $detailTransaksi->kios_transaksi_id = $transaksi->id;
                $detailTransaksi->jenis_transaksi = $kasirJenisTransaksi[$index];
                $detailTransaksi->kios_produk_id = $item;
                $detailTransaksi->serial_number_id = $kasirSN[$index];

                if($kasirJenisTransaksi[$index] =='drone_baru') {
                    $dataProduk = KiosProduk::where('sub_jenis_id', $item)->first();
                    $nilaiPromo = $dataProduk->harga_promo;
                    $nilaiSrp = $dataProduk->srp;

                    $detailTransaksi->harga_jual = $nilaiSrp;
                    $detailTransaksi->harga_promo = $nilaiPromo;

                } else {
                    $detailTransaksi->harga_jual = $kasirSrp[$index];
                    $detailTransaksi->harga_promo = 0;
                }

                $detailTransaksi->save();
                KiosSerialNumber::find($kasirSN[$index])->update(['status' => 'Sold']);
            }

            $transaksi->total_harga = $totalHarga;
            $transaksi->save();

            return back()->with('success', 'Success melakukan transaksi.');

        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }

    }

    public function autocomplete($jenisTransaksi)
    {
        if ($jenisTransaksi == 'drone_baru') {
            // $items = ProdukSubJenis::with('produkjenis')->get();
            $items = KiosProduk::with('subjenis.produkjenis')->where('status', 'Ready')->orWhere('status', 'Promo')->get();
        } elseif ($jenisTransaksi == 'drone_bekas') {
            $items = KiosProdukSecond::with('subjenis.produkjenis')->where('status', 'Ready')->get();
        } elseif ($jenisTransaksi == 'part_baru' || $jenisTransaksi == 'part_bekas') {
            
            $urlApiGudang = 'https://script.google.com/macros/s/AKfycbyGbMFkZyhJAGgZa4Tr8bKObYrNxMo4h-uY1I-tS_SbtmEOKPeCcxO2aU6JjLWedQlFVw/exec';
            $response = Http::post($urlApiGudang, [
                'status' => $jenisTransaksi
            ]);

            $data = $response->json();
            $resultData = [];
            foreach ($data['data'] as $dataNeed) {
                $neededData = [
                    'sku' => $dataNeed[0],
                    'nama_part' => $dataNeed[2],
                    'srp_part' => $dataNeed[8],
                ];
                $resultData[] = $neededData;
            }

            $items = $resultData;

        }

        return response()->json($items);

    }

    public function getSerialNumber($jenisTransaksi, $id)
    {
        if($jenisTransaksi == 'drone_baru') {
            $produkId = KiosProduk::where('sub_jenis_id', $id)->value('id');
            $dataProduk = KiosProduk::where('sub_jenis_id', $id)->first();
            if ($dataProduk->status === 'Promo') {
                $nilai = $dataProduk->harga_promo;
            } else {
                $nilai = $dataProduk->srp;
            }
    
            $dataSN = KiosSerialNumber::where('produk_id', $produkId)->where('status', 'Ready')->get();
        } elseif($jenisTransaksi == 'drone_bekas') {
            $nilai = KiosProdukSecond::where('sub_jenis_id', $id)->value('srp');
            $dataSN = KiosProdukSecond::where('sub_jenis_id', $id)->where('status', 'Ready')->get();
        }
        
        return response()->json(['data_sn' => $dataSN, 'nilai' => $nilai]);
    }

    public function getCustomer($customerId)
    {
        $dataCustomer = Customer::where('id', $customerId)->get();
        return response()->json($dataCustomer);
    }

    public function downloadInvoice(Request $request)
    {
        $html = $request->input('content');
        $noInvoice = $request->input('no_invoice');

        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);

        $newPdf = new Dompdf();
        $newPdf->loadHTML($html);
        $newPdf->setPaper('A5', 'landscape');
        $newPdf->render();

        return $newPdf->download($noInvoice . ".pdf");
    }

}
