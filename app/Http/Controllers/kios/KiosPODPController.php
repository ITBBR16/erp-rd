<?php

namespace App\Http\Controllers\kios;

use Exception;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\kios\KiosAkunRD;
use App\Models\kios\KiosProduk;
use App\Models\customer\Customer;
use App\Models\kios\KiosTransaksi;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\kios\KiosProdukSecond;
use App\Models\kios\KiosSerialNumber;
use App\Models\kios\KiosTransaksiDPPO;
use App\Models\kios\KiosTransaksiDetail;
use App\Repositories\kios\KiosRepository;
use Illuminate\Support\Facades\Http;
use PhpParser\Node\Expr\Empty_;

class KiosPODPController extends Controller
{
    public function __construct(private KiosRepository $suppKiosRepo){}

    public function index()
    {
        $user = auth()->user();
        $divisiName = $this->suppKiosRepo->getDivisi($user);
        $today = Carbon::now();
        $dueDate = $today->copy()->addMonth(2);
        $customerData = Customer::all();
        $akunRd = KiosAkunRD::all();
        $dataTransaksi = KiosTransaksi::orderBy('id', 'desc')->get();

        return view('kios.kasir.dppo', [
            'title' => 'DP / PO Kios',
            'active' => 'dp-po-kios',
            'navActive' => 'kasir',
            'divisi' => $divisiName,
            'dropdown' => '',
            'dropdownShop' => '',
            'today' => $today,
            'duedate' => $dueDate,
            'customerdata' => $customerData,
            'akunrd' => $akunRd,
            'dataTransaksi' => $dataTransaksi,
        ]);
    }

    public function edit($encryptId)
    {
        $id = decrypt($encryptId);
        $user = auth()->user();
        $today = Carbon::now();
        $dueDate = $today->copy()->addMonth(2);
        $divisiName = $this->suppKiosRepo->getDivisi($user);
        $dataTransaksi = KiosTransaksi::findOrFail($id);
        $akunRd = KiosAkunRD::all();

        return view('kios.kasir.editpage.pelunasan-dppo', [
            'title' => 'Pelunasan DP / PO Kios',
            'active' => 'dp-po-kios',
            'navActive' => 'kasir',
            'divisi' => $divisiName,
            'dropdown' => '',
            'dropdownShop' => '',
            'today' => $today,
            'duedate' => $dueDate,
            'dataTransaksi' => $dataTransaksi,
            'akunrd' => $akunRd,
        ]);
    }

    public function update(Request $request, $id)
    {
        $connectionPelunasan = DB::connection('rumahdrone_kios');
        $connectionPelunasan->beginTransaction();

        try {
            $request->validate([
                'nama_customer' => 'required',
                'metode_pembayaran_pelunasan' => 'required',
                'pelunasan_nominal' => 'required|min:1',
                'jenis_transaksi' => 'required|array|min:1',
                'item_id' => 'required|array|min:1',
                'kasir_sn' => 'required|array|min:1',
                'kasir_harga' => 'required|array|min:1',
            ]);

            $pelunasanNamaCustomer = $request->input('nama_customer');
            $pelunasanIdCustomer = $request->input('id_customer');
            $pelunasanMetodePembayaran = $request->input('metode_pembayaran_pelunasan');
            $pelunasanDiscount = $this->sanitizeNominal($request->input('pelunasan_discount'));
            $pelunasanOngkir = $this->sanitizeNominal($request->input('pelunasan_ongkir'));
            $pelunasanNominalPembayaran = $this->sanitizeNominal($request->input('pelunasan_nominal'));
            $pelunasanTax = $request->input('pelunasan_tax');

            // Ambil semua sub jenis yang diperlukan
            $itemIdProduk = $request->input('item_id');
            $subJenisIds = array_unique($itemIdProduk);
            $dataProduk = KiosProduk::whereIn('sub_jenis_id', $subJenisIds)->get();

            // Detial Transaksi
            $pelunasanIdDetailTransaksi = $request->input('id_detail_transaksi');
            $pelunasanJenisTransaksi = $request->input('jenis_transaksi');
            $pelunasanItem = $request->input('item_id');
            $pelunasanSerialNumber = $request->input('kasir_sn');
            $pelunasanSRP = $this->sanitizeNominal($request->input('kasir_harga'));
            $pelunasanModalPart = $request->input('kasir_modal_part');
            $statusTransaksi = $request->input('status_pelunasan');

            $totalHargaKiosBaru = 0;
            $totalHargaKiosBekas = 0;
            $totalHargaGudang = 0;
            $totalHarga = 0;
            $modalKios = 0;
            $modalKiosBekas = 0;
            $modalGudang = 0;

            if(count(array_unique($pelunasanSerialNumber)) !== count($pelunasanSerialNumber)) {
                return back()->with('error', 'Serial Number tidak boleh ada yang sama.');
            }

            $transaksi = KiosTransaksi::findOrFail($id);
            $dpCustomer = $transaksi->transaksidp->jumlah_pembayaran ?? 0;
            $namaMetodePembayaran = $transaksi->metodepembayaran->nama_akun;

            if(!empty($transaksi->status_dp)) {
                $transaksi->status_dp = 'Lunas';
            }

            if(!empty($transaksi->status_po)) {
                $transaksi->status_po = 'Lunas';
            }

            $transaksi->metode_pembayaran = $pelunasanMetodePembayaran;
            $transaksi->ongkir = $pelunasanOngkir;
            $transaksi->discount = $pelunasanDiscount;
            $transaksi->tax = $pelunasanTax;
            $transaksi->save();

            foreach($pelunasanItem as $index => $item) {
                $totalHarga += $pelunasanSRP[$index];

                $produk = $dataProduk->where('sub_jenis_id', $item)->first();
                $findSN = KiosSerialNumber::find($pelunasanSerialNumber[$index]);

                if(!empty($pelunasanIdDetailTransaksi[$index])) {
                    $detailTransaksi = KiosTransaksiDetail::findOrFail($pelunasanIdDetailTransaksi[$index]);
                } else {
                    $detailTransaksi = new KiosTransaksiDetail();
                    $detailTransaksi->kios_transaksi_id = $id;
                }

                $detailTransaksi->jenis_transaksi = $pelunasanJenisTransaksi[$index];
                $detailTransaksi->kios_produk_id = $item;
                $detailTransaksi->serial_number_id = $pelunasanSerialNumber[$index];

                if($pelunasanJenisTransaksi[$index] == 'drone_baru') {
                    $modalKios += $findSN->validasiproduk->orderLists->nilai;
                    $detailTransaksi->harga_jual = $produk->srp;
                    $detailTransaksi->harga_promo = $produk->harga_promo;
                } else {
                    $detailTransaksi->harga_jual = $pelunasanSRP[$index];
                    $detailTransaksi->harga_promo = 0;
                }

                $detailTransaksi->save();
                KiosSerialNumber::find($pelunasanSerialNumber[$index])->update(['status' => 'Sold']);
            }

            KiosTransaksiDetail::where('kios_transaksi_id', $id)
                                ->whereNotIn('id', $pelunasanIdDetailTransaksi)
                                ->delete();

            $transaksi->total_harga = $totalHarga;
            $transaksi->save();

            $decisionLR = $totalHarga - $modalKios + $pelunasanTax;
            $labaKios = 0;
            $rugiKios = 0;
            if($decisionLR > 0) {
                $labaKios = $decisionLR;
            } else {
                $rugiKios = abs($decisionLR);
            }

            $urlFinance = 'https://script.google.com/macros/s/AKfycby_XodelnakZ1ZSi6tnR2vPgQRQ4iFeXY6ZJDyBRSE_dHAZNIxAauYmDu-KWRQcZm8_/exec';
            $payload = [
                'status' => 'Pelunasan',
                'idTransaksi' => $id,
                'dpCustomer' => $dpCustomer,
                'namaAkun' => $namaMetodePembayaran,
                'namaCustomer' => $pelunasanNamaCustomer . '-' . $pelunasanIdCustomer,
                'nominalPembayaran' => $pelunasanNominalPembayaran,
                'discount' => $pelunasanDiscount,
                'kerugianKios' => $rugiKios,
                'kerugianGudang' => 0,
                'labaKiosBaru' => $labaKios,
                'labaKiosBekas' => 0,
                'modalKiosBaru' => $modalKios,
                'modalKiosBekas' => 0,
                'pendapatanGudang' => 0,
                'modalGudang' => 0,
                'ongkir' => $pelunasanOngkir,
            ];

            $sentData = Http::post($urlFinance, $payload);
            $response = json_decode($sentData->body(), true);
            $responseStatus = $response['status'];

            if($responseStatus == 'success') {
                $connectionPelunasan->commit();
                return redirect()->route('dp-po.index')->with('success', 'Success melakukan transaksi.');
            } else {
                $connectionPelunasan->rollBack();
                return back()->with('error', 'Something Went Wrong.');
            }

        } catch (Exception $e) {
            $connectionPelunasan->rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        $connectionKios = DB::connection('rumahdrone_kios');
        $connectionKios->beginTransaction();

        try {
            $userId = auth()->id();
            $validatedData = $request->validate($this->rulesValidasi());

            $totalNominal = 0;
            $dppoStatus = $validatedData['status_dppo'];
            $dppoCustomer = $validatedData['dppo_nama_customer'];
            $dppoPembayaran = $validatedData['dppo_metode_pembayaran'];
            $dppoNominal = $this->sanitizeNominal($request->input('dppo_nominal'));

            $dppoJenisTransaksi = $validatedData['dppo_jenis_transaksi'];
            $dppoIdProduk = $validatedData['dppo_id_produk'];
            $dppoQtyProduk = $validatedData['dppo_qty_produk'];
            $dppoHargaProduk = array_map([$this, 'sanitizeNominal'], $validatedData['dppo_harga']);

            $dppoTransaksi = $this->buatTransaksi($userId, $dppoCustomer, $dppoPembayaran);

            foreach ($dppoIdProduk as $index => $item) {
                $qtyitem = $dppoQtyProduk[$index];
                for ($i = 0; $i < $qtyitem; $i++) {
                    $totalNominal += $dppoHargaProduk[$index];
                    $this->buatDetailTransaksi($dppoTransaksi->id, $dppoJenisTransaksi[$index], $item, $dppoHargaProduk[$index]);
                }
            }

            $this->updateStatusTransaksi($dppoTransaksi, $dppoStatus, $dppoNominal, $totalNominal);

            $namaAkun = $dppoTransaksi->metodepembayaran->nama_akun;
            $getDataCustomer = Customer::findOrFail($dppoCustomer);
            $namaCustomer = $getDataCustomer->first_name . ' ' . $getDataCustomer->id;
            $urlFinance = 'https://script.google.com/macros/s/AKfycby_XodelnakZ1ZSi6tnR2vPgQRQ4iFeXY6ZJDyBRSE_dHAZNIxAauYmDu-KWRQcZm8_/exec';
            $payload = [
                'status' => 'DP',
                'idTransaksi' => $dppoTransaksi->id,
                'dpCustomer' => $dppoNominal,
                'namaAkun' => $namaAkun,
                'namaCustomer' => $namaCustomer,
            ];

            $sentData = Http::post($urlFinance, $payload);
            $response = json_decode($sentData->body(), true);
            $responseStatus = $response['status'];

            $connectionKios->commit();
            return back()->with('success', 'Berhasil membuat ' . $dppoStatus);

        } catch (\Exception $e) {
            $connectionKios->rollBack();
            Log::error('Kesalahan saat membuat transaksi: ', ['error' => $e->getMessage()]);
            return back()->with('error', $e->getMessage());
        }
    }

    private function rulesValidasi()
    {
        return [
            'status_dppo' => 'required',
            'dppo_nama_customer' => 'required',
            'dppo_metode_pembayaran' => 'required',
            'dppo_jenis_transaksi' => 'required|array|min:1',
            'dppo_id_produk' => 'required|array|min:1',
            'dppo_qty_produk' => 'required|array|min:1',
            'dppo_harga' => 'required|array|min:1',
        ];
    }

    private function sanitizeNominal($nominal)
    {
        return preg_replace("/[^0-9]/", "", $nominal);
    }

    private function buatTransaksi($userId, $dppoCustomer, $dppoPembayaran)
    {
        $transaksi = new KiosTransaksi();
        $transaksi->employee_id = $userId;
        $transaksi->customer_id = $dppoCustomer;
        $transaksi->metode_pembayaran = $dppoPembayaran;
        $transaksi->ongkir = 0;
        $transaksi->discount = 0;
        $transaksi->tax = 0;
        $transaksi->save();

        return $transaksi;
    }

    private function buatDetailTransaksi($transaksiId, $jenisTransaksi, $produkId, $hargaProduk)
    {
        $detailTransaksi = new KiosTransaksiDetail();
        $detailTransaksi->kios_transaksi_id = $transaksiId;
        $detailTransaksi->jenis_transaksi = $jenisTransaksi;
        $detailTransaksi->kios_produk_id = $produkId;
        $detailTransaksi->serial_number_id = null;

        if ($jenisTransaksi == 'drone_baru') {
            $dataProduk = KiosProduk::where('sub_jenis_id', $produkId)->first();
            $nilaiPromo = $dataProduk->harga_promo;
            $nilaiSrp = $dataProduk->srp;

            $detailTransaksi->harga_jual = $nilaiSrp;
            $detailTransaksi->harga_promo = $nilaiPromo;
        } else {
            $detailTransaksi->harga_jual = $hargaProduk;
            $detailTransaksi->harga_promo = 0;
        }
        $detailTransaksi->save();
    }

    private function updateStatusTransaksi($transaksi, $status, $nominal, $totalNominal)
    {
        if ($status == 'DP') {
            $transaksi->status_dp = $status;
            KiosTransaksiDPPO::create([
                'kios_transaksi_id' => $transaksi->id,
                'jumlah_pembayaran' => $nominal,
            ]);
        }

        if ($status == 'PO') {
            $transaksi->status_po = $status;

            if ($nominal > 0) {
                $transaksi->status_dp = 'DP';
                KiosTransaksiDPPO::create([
                    'kios_transaksi_id' => $transaksi->id,
                    'jumlah_pembayaran' => $nominal,
                ]);
            }
        }

        $transaksi->total_harga = $totalNominal;
        $transaksi->save();
    }

    public function getSrpProduk($jenisTransaksi, $id)
    {
        if($jenisTransaksi == 'drone_baru') {
            $dataProduk = KiosProduk::where('sub_jenis_id', $id)->first();
            if ($dataProduk->status === 'Promo') {
                $nilai = $dataProduk->harga_promo;
            } else {
                $nilai = $dataProduk->srp;
            }

        } elseif($jenisTransaksi == 'drone_bekas') {
            $nilai = KiosProdukSecond::where('sub_jenis_id', $id)->value('srp');
        }

        return response()->json($nilai);
    }

}
