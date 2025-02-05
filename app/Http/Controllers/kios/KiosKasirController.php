<?php

namespace App\Http\Controllers\kios;

use Exception;
use Carbon\Carbon;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Http\Request;
use App\Models\kios\KiosProduk;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\customer\Customer;
use App\Models\kios\KiosTransaksi;
use Illuminate\Support\Facades\DB;
use App\Models\gudang\GudangProduk;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use App\Models\kios\KiosProdukSecond;
use App\Models\kios\KiosSerialNumber;
use App\Models\kios\KiosTransaksiPart;
use App\Models\kios\KiosTransaksiDetail;
use App\Models\repair\RepairEstimasiPart;
use App\Repositories\umum\UmumRepository;
use App\Models\kios\KiosTransaksiPembayaran;
use App\Models\management\AkuntanDaftarAkun;
use App\Repositories\gudang\repository\GudangProdukIdItemRepository;
use App\Repositories\gudang\repository\GudangTransactionRepository;

class KiosKasirController extends Controller
{
    public function __construct(
        private UmumRepository $umum,
        private GudangProduk $gudangProduk,
        private RepairEstimasiPart $estimasiPart,
        private KiosTransaksiPart $transaksiPart,
        private AkuntanDaftarAkun $daftarAkun,
        private KiosTransaksiPembayaran $transaksiPembayaran,
        private GudangProdukIdItemRepository $idItemGudang,
        private GudangTransactionRepository $transactionGudang,
    ){}

    public function index()
    {
        $user = auth()->user();
        $divisiName = $this->umum->getDivisi($user);
        $today = Carbon::now();
        $dueDate = $today->copy()->addMonth(3);
        $dataCustomer = Customer::all();
        $customerData = $dataCustomer->map(function ($customer) {
            return [
                'id' => $customer->id,
                'display' => "{$customer->first_name} {$customer->last_name} - {$customer->id}"
            ];
        });
        $akunRd = $this->daftarAkun->where('kode_akun', 'like', '111%')->get();
        $invoiceId = KiosTransaksi::latest()->value('id');
        $dataHoldKasir = KiosTransaksi::where('status', 'Hold')->get();
        $dataTransaksi = '';

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
            'daftarAkun' => $akunRd,
            'invoiceid' => $invoiceId,
            'dataHold' => $dataHoldKasir,
            'dataTransaksi' => $dataTransaksi,
        ]);
    }

    public function edit($encryptId)
    {
        $id = decrypt($encryptId);
        $user = auth()->user();
        $today = Carbon::now();
        $dueDate = $today->copy()->addMonth(2);
        $divisiName = $this->umum->getDivisi($user);
        $dataTransaksi = KiosTransaksi::findOrFail($id);
        $akunRd = $this->daftarAkun->where('kode_akun', 'like', '111%')->get();

        return view('kios.kasir.editpage.pelunasan-kasir', [
            'title' => 'Pelunasan Kasir',
            'active' => 'kasir-kios',
            'navActive' => 'kasir',
            'divisi' => $divisiName,
            'dropdown' => '',
            'dropdownShop' => '',
            'today' => $today,
            'duedate' => $dueDate,
            'dataTransaksi' => $dataTransaksi,
            'daftarAkun' => $akunRd,
        ]);
    }

    public function update(Request $request, $id)
    {
        // $connectionKios = DB::connection('rumahdrone_kios');
        // $connectionKios->beginTransaction();

        $userId =auth()->user()->id;

        try {

            $request->validate([
                'nama_customer' => 'required',
                'kasir_metode_pembayaran' => 'required',
                'kasir_nominal_pembayaran' => 'required',
                'jenis_transaksi' => 'required|array|min:1',
                'kasir_sn' => 'required|array|min:1',
                'item_id' => 'required|array|min:1',
                'kasir_harga' => 'required|array|min:1',
            ]);

            $pelunasanCustomerId = $request->input('id_customer');
            $pelunasanMetodePembayaran = $request->input('kasir_metode_pembayaran');
            $pelunasanDiscount = $request->input('kasir_discount');
            $pelunasanOngkir = preg_replace("/[^0-9]/", "",$request->input('kasir_ongkir'));
            $pelunasanTax = preg_replace("/[^0-9]/", "",$request->input('kasir_tax'));
            $pelunasanNominalPembayaran = preg_replace("/[^0-9]/", "",$request->input('kasir_nominal_pembayaran'));
            $pelunasanKeterangan = $request->input('keterangan_pembayaran');

            $pelunasanJenisTransaksi = $request->input('jenis_transaksi');
            $pelunasanItem = $request->input('item_id');
            $pelunasanSN = $request->input('kasir_sn');
            $pelunasanSrp = preg_replace("/[^0-9]/", "", $request->input('kasir_harga'));
            $pelunasanModalPart = $request->input('kasir_modal_part');

            $totalHargaKiosBaru = 0;
            $totalHargaKiosBekas = 0;
            $totalHargaGudang = 0;
            $totalHarga = 0;
            $modalKiosBaru = 0;
            $modalKiosBekas = 0;
            $modalGudang = 0;

            if (count(array_unique($pelunasanSN)) != count($pelunasanSN)) {
                return back()->with('error', 'Serial Number / Id Item tidak boleh ada yang sama');
            }

            // $searchTransaksi = KiosTransaksi::findOrFail($id);
            // $searchTransaksi->update([
            //     'metode_pembayaran' => $pelunasanMetodePembayaran,
            //     'ongkir' => $pelunasanOngkir,
            //     'discount' => $pelunasanDiscount,
            //     'tax' => $pelunasanTax,
            //     'nominal_pembayaran' => $pelunasanNominalPembayaran,
            //     'keterangan' => $pelunasanKeterangan,
            //     'status' => 'Done',
            // ]);

            $existingDT = KiosTransaksiDetail::where('kios_transaksi_id', $id)->get()->keyBy('id');
            // foreach ($pelunasanItem as $index => $item) {
            //     $jenisTransaksi = $pelunasanJenisTransaksi[$index];
            //     $serialNumber = $pelunasanSN[$index];
            //     $srp = $pelunasanSrp[$index];
            //     $totalHarga += $srp;

            //     if ($jenisTransaksi != 'part_baru' || $jenisTransaksi != 'part_bekas') {
                    
            //     }
            // }

            // $connectionKios->commit();
            // return redirect()->route('kasir.index')->with('success', 'Berhasil melakukan pelunasan.');
        } catch (Exception $e) {
            // $connectionKios->rollBack();
            // return back()->with('error', $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        $connectionTransaksiKios = DB::connection('rumahdrone_kios');
        $connectionTransaksiKios->beginTransaction();
        $this->transactionGudang->beginTransaction();

        try{
            $userId = auth()->user()->id;
            $request->validate([
                'nama_customer' => 'required',
                'kasir_metode_pembayaran' => 'required|array|min:1',
                'kasir_nominal_pembayaran' => 'required|array|min:1',
                'jenis_transaksi' => 'required|array|min:1',
                'kasir_sn' => 'required|array|min:1',
                'item_id' => 'required|array|min:1',
                'kasir_harga' => 'required|array|min:1',
            ]);

            $today = Carbon::now();
            $dueDate = $today->copy()->addMonth(3);
            $productNames = $request->input('invoiceProductName');
            $descriptions = $request->input('invoiceDescription');
            $quantities = $request->input('invoiceQty');
            $itemPrices = $request->input('invoiceItemPrice');
            $totalPrices = $request->input('invoiceTotalPrice');

            $kasirCustomer = $request->input('nama_customer');
            $nominalDikembalikan = preg_replace("/[^0-9]/", "", $request->input('kasir_dikembalikan')) ?: 0;
            $pendapatanLainLain = preg_replace("/[^0-9]/", "", $request->input('kasir_pll')) ?: 0;
            $tambahSaldoCustomer = preg_replace("/[^0-9]/", "", $request->input('kasir_sc')) ?: 0;
            $kasirOngkir = preg_replace("/[^0-9]/", "", $request->input('kasir_ongkir')) ?: 0;
            $kasirDiscount = preg_replace("/[^0-9]/", "", $request->input('kasir_discount')) ?: 0;
            $kasirTax = $request->input('kasir_tax') ?: 0;
            $kasirAsuransi = $request->input('kasir_asuransi') ?: 0;
            $kasirKerugian = $request->input('kasir_kerugian');
            
            $kasirKeterangan = $request->input('keterangan_pembayaran');
            $kasirJenisTransaksi = $request->input('jenis_transaksi');
            $kasirItem = $request->input('item_id');
            $kasirSN = $request->input('kasir_sn');
            $kasirSrp = preg_replace("/[^0-9]/", "", $request->input('kasir_harga'));
            $kasirModalPart = $request->input('kasir_modal_part');
            $statusTransaksi = $request->input('status_kasir');

            $totalPembayaran = 0;
            $totalHargaKiosBaru = 0;
            $totalHargaKiosBekas = 0;
            $totalHargaGudang = 0;
            $totalHarga = 0;
            $modalKiosBaru = 0;
            $modalKiosBekas = 0;
            $modalGudang = 0;

            if(count(array_unique($kasirSN)) !== count($kasirSN)) {
                $connectionTransaksiKios->rollBack();
                $this->transactionGudang->rollbackTransaction();
                return back()->with('error', 'Serial Number / Id Item tidak boleh ada yang sama.');
            }

            $transaksi = new KiosTransaksi();
            $transaksi->employee_id = $userId;
            $transaksi->customer_id = $kasirCustomer;
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
                    $statusSN = ($statusTransaksi == 'Done') ? 'Sold' : 'Hold';
                    KiosSerialNumber::find($serialNumber)->update(['status' => $statusSN]);

                    $cekReadySN = KiosSerialNumber::where('produk_id', $item)
                        ->where('status', 'Ready')
                        ->exists();

                    if (!$cekReadySN) {
                        KiosProduk::where('id', $item)->update(['status' => 'Not Ready']);
                    }
                } else {
                    $totalHargaGudang += $srp;
                    $modalGudang += $kasirModalPart[$index];
                    KiosTransaksiPart::create([
                        'transaksi_id' => $transaksi->id,
                        'jenis_transaksi_part' => $jenisTransaksi,
                        'gudang_produk_id' => $item,
                        'gudang_id_item_id' => $serialNumber,
                        'modal_gudang' => $kasirModalPart[$index],
                        'harga_jual_part' => $srp
                    ]);

                    $this->idItemGudang->updateIdItem($serialNumber, ['status_inventory' => 'Sold']);
                }
            }

            $pendapatanKiosBaru = $totalHargaKiosBaru - $modalKiosBaru;
            $pendapatanKiosBekas = $totalHargaKiosBekas - $modalKiosBekas;
            $pendapatanPartBaru = $totalHargaGudang - $modalGudang;

            $products = [];
            $filesFinance = [];
            $namaAkunFinance = [];
            $nilaiAkunFinance = [];

            $saldoCustomer = [];
            $statusSC = [];
            // if ($saldoTerpakai > 0) {
            //     $saldoCustomer[] = $saldoTerpakai;
            //     $statusSC[] = true;
            // }
            if ($tambahSaldoCustomer > 0) {
                $saldoCustomer[] = $tambahSaldoCustomer + $nominalDikembalikan;
                $statusSC[] = false;
            }

            foreach($productNames as $index => $productName) {
                $products[] = [
                    'productName' => $productName ?? '',
                    'description' => $descriptions[$index] ?? '',
                    'qty' => $quantities[$index] ?? 0,
                    'itemPrice' => $itemPrices[$index] ?? 0,
                    'totalPrice' => $totalPrices[$index] ?? 0,
                ];
            }

            $dataInvoiceKasir = [
                'title' => 'Invoice Kasir',
                'invoiceid' => $request->input('invoiceid'),
                'namaCustomer' => $transaksi->customer->first_name . " " . ($transaksi->customer->last_name ?? ''),
                'noTelpon' => $transaksi->customer->no_telpon,
                'jalanCustomer' => $transaksi->customer->nama_jalan,
                'today' => $today,
                'duedate' => $dueDate,
                'products' => $products,
                'subTotal' => $request->input('input_invoice_subtotal', 0),
                'discount' => $request->input('input_invoice_discount', 0),
                'ongkir' => $request->input('input_invoice_ongkir', 0),
                'total' => $request->input('input_invoice_total', 0),
            ];

            $pdf = Pdf::loadView('kios.kasir.invoice.invoice-kasir', $dataInvoiceKasir)->setPaper('a5', 'landscape');;
            $pdfContent = $pdf->output();
            $pdfEncode = base64_encode($pdfContent);
            $filesFinance[] = $pdfEncode;

            foreach($request->input('kasir_metode_pembayaran') as $index => $metodePembayaran) {
                $kasirNominalPembayaran = preg_replace("/[^0-9]/", "", $request->input('kasir_nominal_pembayaran')[$index]);
                $filesFinance[] = base64_encode($request->file('file_bukti_transaksi')[$index]->get());

                $totalPembayaran += $kasirNominalPembayaran;

                $dataPembayaran = [
                    'transaksi_id' => $transaksi->id,
                    'metode_pembayaran_id' => $metodePembayaran,
                    'employee_id' => $userId,
                    'jumlah_pembayaran' => $kasirNominalPembayaran,
                ];
                $namaAkun = $this->daftarAkun->find($metodePembayaran);
                $namaAkunFinance[] = $namaAkun->nama_akun;
                $nilaiAkunFinance[] = $kasirNominalPembayaran;
                $this->transaksiPembayaran->create($dataPembayaran);
            }

            $transaksi->total_harga = $totalHarga;
            $transaksi->save();

            $payloadPembukuan = [
                'saldoCustomer' => $saldoCustomer,
                'statusSC' => $statusSC,
                'files' => $filesFinance,
                'source' => 'Kios',
                'inOut' => 'In',
                'keterangan' => $kasirKeterangan,
                'idEksternal' => "K$transaksi->id",
                'idCustomer' => $transaksi->customer->first_name . " " . ($transaksi->customer->last_name ?? '') . "-" . $transaksi->customer->id,
                'totalNominal' => $totalPembayaran,
                'pendapatanKiosBaru' => $pendapatanKiosBaru,
                'pendapatanKiosBekas' => $pendapatanKiosBekas,
                'pendapatanLain' => $pendapatanLainLain,
                'pendapatanSparepartBaru' => $pendapatanPartBaru,
                'pendapatanSparepartBekas' => 0,
                'persediaanKiosBaru' => $modalKiosBaru,
                'persediaanKiosBekas' => $modalKiosBekas,
                'persediaanSparepartBaru' => $modalGudang,
                'persediaanSparepartBekas' => 0,
                'nilaiDiscount' => $kasirDiscount,
                'nilaiKerugian' => $kasirKerugian,
                'metodePembayaran' => $namaAkunFinance,
                'nilaiMP' => $nilaiAkunFinance,
                'saldoOngkir' => $kasirOngkir
            ];

            $urlJurnalTransit = 'https://script.google.com/macros/s/AKfycbyphX46q41ttogKR_igTGlVvJuTsVurcUIoA6cAPkdrbbPeaigoX1vg9GSRyXcha9km/exec';
            $responseFinance = Http::post($urlJurnalTransit, $payloadPembukuan);

            $connectionTransaksiKios->commit();
            $this->transactionGudang->commitTransaction();

            return back()->with('success', 'Berhasil membuat kasir baru.');

        } catch (Exception $e) {
            $connectionTransaksiKios->rollBack();
            $this->transactionGudang->rollbackTransaction();
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
            $dataPart = $this->gudangProduk->where('status', 'Ready')->orWhere('status', 'Promo')->get();
            $resultData = $dataPart->map(function ($part) {
                return [
                    'id' => $part->id,
                    'nama_part' => $part->produkSparepart->nama_internal
                ];
            });

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
            $dataGudangEstimasi = $this->estimasiPart
                ->where('gudang_produk_id', $id)
                ->whereNotNull('tanggal_dikirim')
                ->where('active', 'Active')
                ->sum('modal_gudang');

            $dataGudangTransaksi = $this->transaksiPart
                ->where('gudang_produk_id', $id)
                ->sum('modal_gudang');

            $dataGudang = $this->gudangProduk
                ->where('id', $id)
                ->whereIn('status', ['Ready', 'Promo'])
                ->first();

            if (!$dataGudang) {
                throw new \Exception("Data gudang tidak ditemukan");
            }

            $dataSubGudang = $dataGudang->gudangIdItem()->where('status_inventory', 'Ready')->get();
            $dataSN = $dataSubGudang->map(function ($item) {
                if ($item->produk_asal == 'Belanja') {
                    $supplierId = optional($item->gudangBelanja)->gudang_supplier_id;
                    return [
                        'id' => $item->id,
                        'id_item' => 'N.' . $item->gudang_belanja_id . '.' . $supplierId . '.' . $item->id,
                    ];
                } elseif ($item->produk_asal == 'Split') {
                    $supplierId = optional($item->gudangBelanja)->gudang_supplier_id;
                    return [
                        'id' => $item->id,
                        'id_item' => 'P.' . $item->gudang_belanja_id . '.' . $supplierId . '.' . $item->id,
                    ];
                }
            });
            $totalSN = $dataSubGudang->count();

            if ($totalSN === 0) {
                throw new \Exception("Tidak ada item dengan status 'Ready' di gudang");
            }

            $modalAwal = $dataGudang->modal_awal ?? 0;
            $modalGudang = ($modalAwal - ($dataGudangEstimasi + $dataGudangTransaksi)) / $totalSN;
            $hargaJualGudang = ($dataGudang->status == 'Promo') ? $dataGudang->harga_promo : $dataGudang->harga_global;
            $nilai = [
                'modalGudang' => $modalGudang,
                'hargaGlobal' => $hargaJualGudang,
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
        $data = json_decode($request->getContent(), true);

        if (!$data) {
            return response()->json(['error' => 'Invalid JSON data'], 400);
        }

        Log::info('Decoded Data:', $data);

        $html = '<html><head><meta charset="UTF-8"></head><body>';
        $html .= $data['content'];
        $html .= '</body></html>';

        $noInvoice = $data['no_invoice'];

        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('defaultFont', 'sans-serif');

        $newPdf = new Dompdf($options);
        $newPdf->loadHtml($html);
        $newPdf->setPaper('A5', 'landscape');
        $newPdf->render();

        return response()->stream(function () use ($newPdf) {
            echo $newPdf->output();
        }, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="' . $noInvoice . '.pdf"',
        ]);
    }

    public function previewPdfKasir(Request $request)
    {
        try {
            Log::info('Request Data: ', $request->all());

            $today = Carbon::now();
            $dueDate = $today->copy()->addMonth(3);
            $products = [];

            $productNames = $request->input('productName', []);
            $descriptions = $request->input('description', []);
            $quantities = $request->input('qty', []);
            $itemPrices = $request->input('itemPrice', []);
            $totalPrices = $request->input('totalPrice', []);

            for ($i = 0; $i < count($productNames); $i++) {
                $products[] = [
                    'productName' => $productNames[$i] ?? '',
                    'description' => $descriptions[$i] ?? '',
                    'qty' => $quantities[$i] ?? 0,
                    'itemPrice' => $itemPrices[$i] ?? 0,
                    'totalPrice' => $totalPrices[$i] ?? 0,
                ];
            }

            $data = [
                'title' => 'Invoice Kasir',
                'invoiceid' => $request->input('invoiceid'),
                'namaCustomer' => $request->input('invoice_nama_customer'),
                'noTelpon' => $request->input('invoice_no_tlp'),
                'jalanCustomer' => $request->input('invoice_jalan'),
                'today' => $today,
                'duedate' => $dueDate,
                'products' => $products,
                'subTotal' => $request->input('invoice_subtotal', 0),
                'discount' => $request->input('invoice_discount', 0),
                'ongkir' => $request->input('invoice_ongkir', 0),
                'total' => $request->input('invoice_total', 0),
            ];

            $pdf = Pdf::loadView('kios.kasir.invoice.invoice-kasir', $data)
                        ->setPaper('a5', 'landscape');

            return $pdf->stream();
        } catch (\Exception $e) {
            Log::error('Error generating PDF: ' . $e->getMessage());
            return response()->json(['error' => 'Gagal membuat PDF'], 500);
        }
    }

}
