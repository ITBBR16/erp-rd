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
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use App\Models\kios\KiosProdukSecond;
use App\Models\kios\KiosSerialNumber;
use App\Models\kios\KiosTransaksiDetail;
use App\Models\kios\KiosTransaksiPart;
use App\Repositories\kios\KiosRepository;

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
        $connectionTransaksiKios = DB::connection('rumahdrone_kios');
        $connectionTransaksiKios->beginTransaction();

        try{
            $userId = auth()->user()->id;
            $request->validate([
                'nama_customer' => 'required',
                'kasir_metode_pembayaran' => 'required',
                'kasir_nominal_pembayaran' => 'required',
                'jenis_transaksi' => 'required|array|min:1',
                'kasir_sn' => 'required|array|min:1',
                'item_id' => 'required|array|min:1',
                'kasir_harga' => 'required|array|min:1',
            ]);
            
            $kasirCustomer = $request->input('nama_customer');
            $kasirMetodePembayaran = $request->input('kasir_metode_pembayaran');
            $kasirOngkir = preg_replace("/[^0-9]/", "", $request->input('kasir_ongkir'));
            $kasirDiscount = preg_replace("/[^0-9]/", "", $request->input('kasir_discount'));
            $kasirTax = $request->input('kasir_tax');
            $kasirKeterangan = $request->input('keterangan_pembayaran');

            $kasirJenisTransaksi = $request->input('jenis_transaksi');
            $kasirItem = $request->input('item_id');
            $kasirSN = $request->input('kasir_sn');
            $kasirSrp = preg_replace("/[^0-9]/", "", $request->input('kasir_harga'));
            $kasirModalPart = $request->input('kasir_modal_part');
            $statusTransaksi = $request->input('status_kasir');

            $totalHargaKiosBaru = 0;
            $totalHargaKiosBekas = 0;
            $totalHargaGudang = 0;
            $totalHarga = 0;
            $modalKiosBaru = 0;
            $modalKiosBekas = 0;
            $modalGudang = 0;

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
            $transaksi->status = $statusTransaksi;
            $transaksi->keterangan = $kasirKeterangan;
            $transaksi->save();

            foreach($kasirItem as $index => $item) {
                $totalHarga += $kasirSrp[$index];
                $jenisTransaksi = $kasirJenisTransaksi[$index];
                $serialNumber = $kasirSN[$index];
                $srp = $kasirSrp[$index];

                if ($jenisTransaksi != 'part_baru' && $jenisTransaksi != 'part_bekas') {
                    $detailTransaksi = new KiosTransaksiDetail();
                    $detailTransaksi->kios_transaksi_id = $transaksi->id;
                    $detailTransaksi->jenis_transaksi = $jenisTransaksi;
                    $detailTransaksi->kios_produk_id = $item;
                    $detailTransaksi->serial_number_id = $serialNumber;

                    if ($jenisTransaksi == 'drone_baru') {
                        $findSN = KiosSerialNumber::find($serialNumber);
                        $totalHargaKiosBaru += $srp;
                        $modalKiosBaru += $findSN->validasiproduk->orderLists->nilai;

                        $dataProduk = KiosProduk::where('sub_jenis_id', $item)->first();
                        $detailTransaksi->harga_jual = $dataProduk->srp;
                        $detailTransaksi->harga_promo = $dataProduk->harga_promo;
                        $detailTransaksi->support_supplier = 0;
                    } elseif ($jenisTransaksi == 'drone_bekas') {
                        $totalHargaKiosBekas += $srp;
                        $dataProdukBekas = KiosProdukSecond::where('serial_number', $serialNumber)->first();
                        $modalKiosBekas += $dataProdukBekas->modal_bekas;

                        $detailTransaksi->harga_jual = $srp;
                        $detailTransaksi->harga_promo = 0;
                        $detailTransaksi->support_supplier = 0;
                    }

                    $detailTransaksi->save();
                    KiosSerialNumber::find($serialNumber)->update(['status' => 'Sold']);
                } else {
                    $totalHargaGudang += $srp;
                    $modalGudang += $kasirModalPart[$index];
                    KiosTransaksiPart::create([
                        'transaksi_id' => $transaksi->id,
                        'jenis_transaksi_part' => $jenisTransaksi,
                        'sku_part' => $item,
                        'id_item_part' => $serialNumber,
                        'harga_modal_part' => $kasirModalPart[$index],
                        'harga_jual_part' => $srp
                    ]);
                }
            }

            $transaksi->total_harga = $totalHarga;
            $transaksi->save();

            $namaMetodePembayaran = $transaksi->metodepembayaran->nama_akun;
            $namaCustomer = $transaksi->customer->first_name;

            $decisionLRBaru = $totalHargaKiosBaru - $modalKiosBaru + $kasirTax;
            $labaKiosBaru = 0;
            $rugiKiosBaru = 0;
            if($decisionLRBaru > 0) {
                $labaKiosBaru = $decisionLRBaru;
            } else {
                $rugiKiosBaru = abs($decisionLRBaru);
            }

            $decisionLRBekas = $totalHargaKiosBekas - $modalKiosBekas;
            $labaKiosBekas = 0;
            $rugiKiosBekas = 0;
            if($decisionLRBekas > 0) {
                $labaKiosBekas = $decisionLRBekas;
            } else {
                $rugiKiosBekas = abs($decisionLRBekas);
            }

            $decusionLRGudang = $totalHargaGudang - $modalGudang;
            $labaGudang = 0;
            $rugiGudang = 0;
            if($decusionLRGudang > 0) {
                $labaGudang = $decusionLRGudang;
            } else {
                $rugiGudang = abs($decusionLRGudang);
            }

            $urlFinance = 'https://script.google.com/macros/s/AKfycby_XodelnakZ1ZSi6tnR2vPgQRQ4iFeXY6ZJDyBRSE_dHAZNIxAauYmDu-KWRQcZm8_/exec';
            $payload = [
                'status' => 'Pelunasan',
                'idTransaksi' => $transaksi->id,
                'dpCustomer' => 0,
                'namaAkun' => $namaMetodePembayaran,
                'namaCustomer' => $namaCustomer . '-' . $kasirCustomer,
                'nominalPembayaran' => $totalHarga,
                'discount' => $kasirDiscount,
                'kerugianKios' => $rugiKiosBaru,
                'kerugianGudang' => $rugiGudang,
                'labaKiosBaru' => $labaKiosBaru,
                'labaKiosBekas' => $labaKiosBekas,
                'modalKiosBaru' => $modalKiosBaru,
                'modalKiosBekas' => $modalKiosBekas,
                'pendapatanGudang' => $labaGudang,
                'modalGudang' => $modalGudang,
                'ongkir' => $kasirOngkir,
            ];

            $sentData = Http::post($urlFinance, $payload);
            $response = json_decode($sentData->body(), true);
            $responseStatus = $response['status'];

            if($responseStatus == 'success') {
                $connectionTransaksiKios->commit();
                return back()->with('success', 'Success melakukan transaksi.');
            } else {
                $connectionTransaksiKios->rollBack();
                return back()->with('error', 'Something Went Wrong.');
            }

        } catch (Exception $e) {
            $connectionTransaksiKios->rollBack();
            return back()->with('error', $e->getMessage());
        }

    }

    public function autocomplete($jenisTransaksi)
    {
        if ($jenisTransaksi == 'drone_baru') {
            $items = KiosProduk::with('subjenis')->where('status', 'Ready')->orWhere('status', 'Promo')->get();
        } elseif ($jenisTransaksi == 'drone_bekas') {
            $items = KiosProdukSecond::with('subjenis')->where('status', 'Ready')->get();
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
        } elseif ($jenisTransaksi == 'part_baru' || $jenisTransaksi == 'part_bekas') {

            $urlApiGudang = 'https://script.google.com/macros/s/AKfycbzWFWbEhcdIyslBXQQ4QjZ9DI_nn1JYcjHHZYoHgwyDGFV7Izs3WOf11fBdW6YysPpYOQ/exec';
            $response = Http::post($urlApiGudang, [
                'sku' => $id
            ]);

            $data = $response->json();
            $resultData = [];
            foreach ($data['data'] as $dataNeed) {
                $dataII = [
                    'idItem' => $dataNeed,
                ];
                $resultData[] = $dataII;
            }

            $dataSN = $resultData;
            $nilai = [
                'nilai' => $data['nilai'],
                'modal' => $data['modal'],
            ];

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
