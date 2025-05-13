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
use App\Models\ekspedisi\Ekspedisi;
use App\Models\gudang\GudangProduk;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\kios\KiosProdukBnob;
use Illuminate\Support\Facades\Http;
use App\Models\kios\KiosProdukSecond;
use App\Models\kios\KiosSerialNumber;
use App\Models\kios\KiosTransaksiPart;
use App\Models\kios\KiosTransaksiDetail;
use App\Models\repair\RepairEstimasiPart;
use App\Repositories\umum\UmumRepository;
use App\Models\kios\KiosTransaksiPembayaran;
use App\Models\management\AkuntanDaftarAkun;
use App\Repositories\logistik\repository\EkspedisiRepository;
use App\Repositories\gudang\repository\GudangTransactionRepository;
use App\Repositories\gudang\repository\GudangProdukIdItemRepository;
use App\Repositories\logistik\repository\LogistikTransactionRepository;

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
        private EkspedisiRepository $ekspedisi,
        private LogistikTransactionRepository $ekspedisiTransaction,
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
        $ekspedisi = Ekspedisi::all();

        return view('kios.kasir.index', [
            'title' => 'Kasir Kios',
            'active' => 'kasir-kios',
            'navActive' => 'kasir',
            'divisi' => $divisiName,
            'today' => $today,
            'duedate' => $dueDate,
            'customerdata' => $customerData,
            'daftarAkun' => $akunRd,
            'invoiceid' => $invoiceId,
            'dataHold' => $dataHoldKasir,
            'dataTransaksi' => $dataTransaksi,
            'ekspedisi' => $ekspedisi
        ]);
    }

    public function indexHistory()
    {
        $user = auth()->user();
        $divisiName = $this->umum->getDivisi($user);
        $dataHistory = KiosTransaksi::orderBy('id', 'desc')->get();

        return view('kios.kasir.history-transaksi', [
            'title' => 'History Transaksi',
            'active' => 'history-transaksi',
            'navActive' => 'kasir',
            'divisi' => $divisiName,
            'dataHistory' => $dataHistory,
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
        $this->ekspedisiTransaction->beginTransaction();

        try{
            $user = auth()->user();
            $userId = $user->id;
            $divisiId = $user->divisi_id;
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
            $kasirPacking = preg_replace("/[^0-9]/", "", $request->input('kasir_packing')) ?: 0;
            $kasirDiscount = preg_replace("/[^0-9]/", "", $request->input('kasir_discount')) ?: 0;
            $kasirTax = $request->input('kasir_tax') ?: 0;
            $kasirAsuransi = $request->input('kasir_asuransi') ?: 0;
            $kasirKerugian = preg_replace("/[^0-9]/", "", $request->input('kasir_kerugian')) ?: 0;
            $layananEkspedisi = $request->input('layanan');
            $totalOngkirKasir = $kasirOngkir + $kasirAsuransi + $kasirPacking;

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
                $this->ekspedisiTransaction->rollbackTransaction();
                $this->transactionGudang->rollbackTransaction();
                return back()->with('error', 'Serial Number / Id Item tidak boleh ada yang sama.');
            }

            $transaksi = new KiosTransaksi();
            $transaksi->employee_id = $userId;
            $transaksi->customer_id = $kasirCustomer;
            $transaksi->ongkir = $totalOngkirKasir;
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

                        $statusSN = ($statusTransaksi == 'Done') ? 'Sold' : 'Hold';
                        $findSN->update(['status' => $statusSN]);

                        $cekReadySN = KiosSerialNumber::where('produk_id', $item)
                            ->where('status', 'Ready')
                            ->exists();

                        if (!$cekReadySN) {
                            KiosProduk::where('id', $item)->update(['status' => 'Not Ready']);
                        }

                    } elseif ($jenisTransaksi == 'drone_bekas') {
                        $totalHargaKiosBekas += $srp;
                        $dataProdukBekas = KiosProdukSecond::find($serialNumber);
                        $modalKiosBekas += $dataProdukBekas->modal_bekas;

                        $detailTransaksi->harga_jual = $srp;
                        $detailTransaksi->harga_promo = 0;
                        $detailTransaksi->support_supplier = 0;

                        $dataProdukBekas->update(['status' => 'Sold']);
                    } elseif ($jenisTransaksi == 'drone_bnob') {
                        $totalHargaKiosBaru += $srp;
                        $dataProdukBnob = KiosProdukBnob::find($serialNumber);
                        $modalKiosBaru += $dataProdukBnob->modal_bnob;

                        $detailTransaksi->harga_jual = $srp;
                        $detailTransaksi->harga_promo = 0;
                        $detailTransaksi->support_supplier = 0;

                        $dataProdukBnob->update(['status' => 'Sold']);
                    }

                    $detailTransaksi->save();

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
            $nilaiKerugianGudang = $modalGudang - $totalHargaGudang;

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

            if ($totalOngkirKasir > 0) {
                $nominalProduk = $totalHarga - $kasirDiscount;
                $dataRequestLogistik = [
                    'employee_id' => $userId,
                    'divisi_id' => $divisiId,
                    'source_id' => $transaksi->id,
                    'penerima_id' => $kasirCustomer,
                    'layanan_id' => $layananEkspedisi,
                    'biaya_customer_ongkir' => $kasirOngkir,
                    'biaya_customer_packing' => $kasirPacking,
                    'nominal_produk' => $nominalProduk,
                    'nominal_asuransi' => $kasirAsuransi,
                    'tipe_penerima' => 'Customer',
                    'tanggal_request' => now(),
                    'status_request' => 'Request Packing',
                ];
    
                $this->ekspedisi->createLogRequest($dataRequestLogistik);
            }

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
                'nilaiKerugianGudang' => $nilaiKerugianGudang,
                'metodePembayaran' => $namaAkunFinance,
                'nilaiMP' => $nilaiAkunFinance,
                'saldoOngkir' => $totalOngkirKasir
            ];

            $urlJurnalTransit = 'https://script.google.com/macros/s/AKfycbyphX46q41ttogKR_igTGlVvJuTsVurcUIoA6cAPkdrbbPeaigoX1vg9GSRyXcha9km/exec';
            $responseFinance = Http::post($urlJurnalTransit, $payloadPembukuan);

            $connectionTransaksiKios->commit();
            $this->ekspedisiTransaction->commitTransaction();
            $this->transactionGudang->commitTransaction();

            return back()->with('success', 'Berhasil membuat kasir baru.');

        } catch (Exception $e) {
            $connectionTransaksiKios->rollBack();
            $this->ekspedisiTransaction->rollbackTransaction();
            $this->transactionGudang->rollbackTransaction();
            return back()->with('error', $e->getMessage());
        }

    }

    public function updateDataCustomer(Request $request)
    {
        try {

            $connectionTransaksi = DB::connection('rumahdrone_customer');
            $connectionTransaksi->beginTransaction();

            $dataCustomer = [
                'provinsi_id' => $request->input('provinsi_customer'),
                'kota_kabupaten_id' => $request->input('kota_customer'),
                'kecamatan_id' => $request->input('kecamatan_customer'),
                'kelurahan_id' => $request->input('kelurahan_customer'),
                'kode_pos' => $request->input('kode_pos_customer'),
                'nama_jalan' => $request->input('alamat_customer'),
            ];

            $customer = Customer::findOrFail($request->input('id_customer'));
            $customer->update($dataCustomer);

            $connectionTransaksi->commit();

        } catch (Exception $e) {
            $connectionTransaksi->rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    public function autocomplete($jenisTransaksi)
    {
        if ($jenisTransaksi == 'drone_baru') {
            $items = KiosProduk::with('subjenis')->where('status', 'Ready')->orWhere('status', 'Promo')->get();
        } elseif ($jenisTransaksi == 'drone_bnob') {
            $items = KiosProdukBnob::with('subjenis')
                    ->where('status', 'Ready')
                    ->get()
                    ->unique('sub_jenis_id')
                    ->values();
        } elseif ($jenisTransaksi == 'drone_bekas') {
            $items = KiosProdukSecond::with('subjenis')
                    ->where('status', 'Ready')
                    ->get()
                    ->unique('sub_jenis_id')
                    ->values();
        } elseif ($jenisTransaksi == 'part_baru' || $jenisTransaksi == 'part_bekas') {
            $dataPart = $this->gudangProduk->where('status', 'Ready')->orWhere('status', 'Promo')->get();
            $resultData = $dataPart->map(function ($part) {
                return [
                    'id' => $part->produkSparepart->id,
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
        } elseif ($jenisTransaksi == 'drone_bnob') {
            $nilai = KiosProdukBnob::where('sub_jenis_id', $id)->value('srp');
            $dataSN = KiosProdukBnob::where('sub_jenis_id', $id)->where('status', 'Ready')->get();
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
                ->where('produk_sparepart_id', $id)
                ->whereIn('status', ['Ready', 'Promo'])
                ->first();

            if (!$dataGudang) {
                throw new \Exception("Data gudang tidak ditemukan");
            }

            $dataSubGudang = $dataGudang->produkSparepart->gudangIdItem()->where('status_inventory', 'Ready')->get();
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
                } else {
                    $supplierId = optional($item->gudangBelanja)->gudang_supplier_id;
                    return [
                        'id' => $item->id,
                        'id_item' => 'E.' . $item->gudang_belanja_id . '.' . $supplierId . '.' . $item->id,
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
                'modalGudang' => round($modalGudang),
                'hargaGlobal' => $hargaJualGudang,
            ];
        }

        return response()->json(['data_sn' => $dataSN, 'nilai' => $nilai]);
    }

    public function getNilaiDroneSecond($id)
    {
        $nilai = KiosProdukSecond::where('id', $id)->where('status', 'Ready')->value('srp');

        return response()->json(['nilai' => $nilai]);
    }

    public function getNilaiBnob($id)
    {
        $nilai = KiosProdukBnob::where('id', $id)->where('status', 'Ready')->value('srp');
        return response()->json(['nilai' => $nilai]);
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

    public function previewPdfKasir($encryptId)
    {
        $id = decrypt($encryptId);
        $dataTransaksi = KiosTransaksi::find($id);
        $invoiceid = $dataTransaksi->created_at . $id;
        $duedate = $dataTransaksi->created_at->copy()->addMonth(3);
        $dataView = [
            'title' => 'Preview Invoice',
            'dataTransaksi' => $dataTransaksi,
            'invoiceid' => $invoiceid,
            'duedate' => $duedate
        ];

        $pdf = Pdf::loadView('kios.kasir.invoice.invoice-kasir', $dataView)
                    ->setPaper('a5', 'portrait');

        return $pdf;
    }

}
