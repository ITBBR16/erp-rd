<?php

namespace App\Services\gudang;

use Exception;
use Illuminate\Http\Request;
use App\Models\gudang\GudangProduk;
use App\Models\kios\KiosTransaksiPart;
use App\Models\repair\RepairEstimasiPart;
use App\Repositories\gudang\repository\GudangProdukIdItemRepository;
use App\Repositories\umum\UmumRepository;
use App\Repositories\repair\repository\RepairCaseRepository;
use App\Repositories\repair\repository\RepairEstimasiRepository;
use App\Repositories\gudang\repository\GudangTransactionRepository;

class GudangKonfirmasiPengirimanServices
{
    public function __construct(
        private UmumRepository $umum,
        private GudangTransactionRepository $transaction,
        private RepairCaseRepository $repairCase,
        private RepairEstimasiRepository $repairEstimasi,
        private GudangProdukIdItemRepository $produkIdITem,
        private RepairEstimasiPart $estimasiPart,
        private KiosTransaksiPart $transaksiPart,
        private GudangProduk $gudangProduk,
    ){}

    public function index()
    {
        $user = auth()->user();
        $divisiName = $this->umum->getDivisi($user);
        $repairCase = $this->repairCase->getAllDataNeededNewCase();
        $case = $repairCase['data_case'];
        $sortedCase = $case->sortByDesc(function ($singleCase) {
            return $singleCase->estimasi->created_at ?? null;
        });

        return view('gudang.distribusi-produk.konfirmasi.main-distribusi', [
            'title' => 'Gudang Konfirmasi',
            'active' => 'gudang-konfirmasi',
            'navActive' => 'distribusi',
            'divisi' => $divisiName,
            'repairCase' => $sortedCase
        ]);
    }

    public function pageKonfirmasi($encryptId)
    {
        $user = auth()->user();
        $divisiName = $this->umum->getDivisi($user);
        $id = decrypt($encryptId);
        $dataCase = $this->repairCase->findCase($id);
        $dataIdItems = $dataCase
        ->estimasi
        ->estimasiPart
        ->mapWithKeys(function ($estimasiPart) {
            return [
                $estimasiPart->id => $estimasiPart->sparepartGudang->produkSparepart->gudangIdItem
                    ->where('status_inventory', 'Ready')
                    ->map(function ($gudangIdItem) {
                        $nama = null;

                        if ($gudangIdItem->produk_asal === 'Belanja') {
                            $nama = 'N' . $gudangIdItem->gudang_belanja_id . '.' . $gudangIdItem->gudangBelanja->gudang_supplier_id . '.' . $gudangIdItem->id;
                        } elseif ($gudangIdItem->produk_asal == 'Split') {
                            $nama = 'P' . $gudangIdItem->gudang_belanja_id . '.' . $gudangIdItem->gudangBelanja->gudang_supplier_id . '.' . $gudangIdItem->id;
                        } else {
                            $nama = 'E' . $gudangIdItem->gudang_belanja_id . '.' . $gudangIdItem->gudangBelanja->gudang_supplier_id . '.' . $gudangIdItem->id;
                        }

                        return [
                            'id' => $gudangIdItem->id,
                            'nama' => $nama,
                        ];
                    })
            ];
        });

        return view('gudang.distribusi-produk.page.konfirmasi-sparepart', [
            'title' => 'Gudang Konfirmasi',
            'active' => 'gudang-konfirmasi',
            'navActive' => 'distribusi',
            'divisi' => $divisiName,
            'dataCase' => $dataCase,
            'dataIdItems' => $dataIdItems,
        ]);
    }

    public function sendPart(Request $request)
    {
        try {
            $this->transaction->beginTransaction();
            $this->repairCase->beginTransaction();

            $timeStamp = now();
            $partId = $request->input('gudang_part');
            $idEstimasiPart = $request->input('id_estimasi_part');
            $idItemGudang = $request->input('id_item');

            $filteredItems = array_filter($idItemGudang, function ($item) {
                return !empty($item);
            });

            if (empty($filteredItems)) {
                throw new Exception('Minimal satu id_item harus diisi.');
            }

            foreach ($filteredItems as $index => $idItem) {
                $modalGudang = $this->countModalGudang($partId[$index]);
                $dataEstimasiPart = [
                    'id_item' => $idItem,
                    'modal_gudang' => $modalGudang['modalGudang'],
                    'tanggal_dikirim' => $timeStamp,
                ];
                $this->repairEstimasi->updateEstimasiPart($dataEstimasiPart, $idEstimasiPart[$index]);
                $this->produkIdITem->updateIdItem($idItem, ['status_inventory' => 'Piutang']);
            }

            $this->transaction->commitTransaction();
            $this->repairCase->commitTransaction();

            return ['status' => 'success', 'message' => 'Sparepart berhasil dikirim.'];

        } catch (Exception $e) {
            $this->transaction->rollbackTransaction();
            $this->repairCase->rollBackTransaction();
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    public function countModalGudang($id)
    {
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
        $totalSN = $dataSubGudang->count();
        $modalAwal = $dataGudang->modal_awal ?? 0;
        $modalGudang = ($modalAwal - ($dataGudangEstimasi + $dataGudangTransaksi)) / $totalSN;
        $hargaJualGudang = ($dataGudang->status == 'Promo') ? $dataGudang->harga_promo : $dataGudang->harga_global;
        $nilai = [
            'modalGudang' => round($modalGudang),
            'hargaGlobal' => $hargaJualGudang,
            'hargaRepair' => $dataGudang->harga_internal,
            'promoGudang' => $dataGudang->harga_promo
        ];
            
        return $nilai;
    }

    public function checkCount($id)
    {
        $dataGudangEstimasi = $this->estimasiPart
            ->where('gudang_produk_id', $id)
            ->whereNotNull('tanggal_dikirim')
            ->where('active', 'Active')
            ->sum('modal_gudang');

        $dataEstimasi = $this->estimasiPart
            ->where('gudang_produk_id', $id)
            ->whereNotNull('tanggal_dikirim')
            ->where('active', 'Active')
            ->get();

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
        $totalSN = $dataSubGudang->count();
        $modalAwal = $dataGudang->modal_awal ?? 0;
        $modalGudang = ($modalAwal - ($dataGudangEstimasi + $dataGudangTransaksi)) / $totalSN;
        $hargaJualGudang = ($dataGudang->status == 'Promo') ? $dataGudang->harga_promo : $dataGudang->harga_global;
        $nilai = [
            'dataEstimasi' => $dataEstimasi,
            'dataEstimasiSum' => $dataGudangEstimasi,
            'dataTransaksi' => $dataGudangTransaksi,
            'dataGudang' => $dataGudang,
            'modalGudang' => round($modalGudang),
            'hargaGlobal' => $hargaJualGudang,
            'hargaRepair' => $dataGudang->harga_internal,
            'promoGudang' => $dataGudang->harga_promo
        ];
            
        return $nilai;
    }

}