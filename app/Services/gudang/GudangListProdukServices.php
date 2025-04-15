<?php

namespace App\Services\gudang;

use Exception;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\gudang\GudangProduk;
use App\Models\kios\KiosTransaksiPart;
use App\Models\repair\RepairEstimasiPart;
use App\Repositories\umum\UmumRepository;
use App\Repositories\gudang\repository\GudangProdukRepository;
use App\Repositories\gudang\repository\GudangTransactionRepository;

class GudangListProdukServices
{
    public function __construct(
        private UmumRepository $umum,
        private GudangTransactionRepository $transaction,
        private GudangProdukRepository $produk,
        private GudangProduk $sparepart,
        private RepairEstimasiPart $estimasiPart,
        private KiosTransaksiPart $transaksiPart,
    ){}

    public function index()
    {
        $user = auth()->user();
        $divisiName = $this->umum->getDivisi($user);
        $dataProduk = $this->produk->getAllProduk();

        foreach ($dataProduk as $produk) {
            try {
                $modalGudang = $this->countModalGudang($produk->produkSparepart->id);
                $produk->modal_gudang = $modalGudang['modalGudang'];
            } catch (\Exception $e) {
                $produk->modal_gudang = 0;
            }
        }

        return view('gudang.produk.list-produk.list-produk', [
            'title' => 'Gudang Produk',
            'active' => 'gudang-produk',
            'navActive' => 'produk',
            'divisi' => $divisiName,
            'dataProduk' => $dataProduk,
        ]);
    }

    public function searchListProduk(Request $request)
    {
        try {
            $query = $request->input('search');

            $dataProduk = GudangProduk::join('rumahdrone_produk.produk_sparepart as ps', 'gudang_produk.produk_sparepart_id', '=', 'ps.id')
                ->whereRaw("LOWER(ps.nama_internal) LIKE LOWER(?)", ["%{$query}%"])
                ->select('gudang_produk.*', 'ps.nama_internal')
                ->paginate(70);

            foreach ($dataProduk as $produk) {
                try {
                    $modalGudang = $this->countModalGudang($produk->produkSparepart->id);
                    $produk->modal_gudang = $modalGudang['modalGudang'];
                } catch (\Exception $e) {
                    $produk->modal_gudang = 0;
                }
            }

            return response()->json([
                'html' => view('gudang.produk.list-produk.partial.partial-list-produk', compact('dataProduk'))->render()
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function showListProduk(Request $request)
    {
        $products = $this->produk->getAllProduk();

        if ($request->keyword != '') {
            $products = $this->sparepart->produkSparepart->where('nama_internal', 'LIKE', '%' . $request->keyword . '%')->get();
        }

        return response()->json([
            'dataProduk' => $products
        ]);
    }

    public function updatePromoProduk($id, Request $request)
    {
        try {
            $this->transaction->beginTransaction();

            $hargaPromo = preg_replace("/[^0-9]/", "", $request->input('harga_promo')) ?: 0;
            $startTanggalInput = $request->input('tanggal_start_promo');
            $endTanggalInput = $request->input('tanggal_end_promo');
            $formatedStart = Carbon::createFromFormat('m/d/Y', $startTanggalInput)->format('Y-m-d');
            $formatedEnd = Carbon::createFromFormat('m/d/Y', $endTanggalInput)->format('Y-m-d');

            $dataPromo = [
                'tanggal_start_promo' => $formatedStart,
                'tanggal_end_promo' => $formatedEnd,
                'harga_promo' => $hargaPromo,
                'status' => 'Promo'
            ];
            
            $this->produk->updateProduk($id, $dataPromo);
            $this->transaction->commitTransaction();

            return ['status' => 'success', 'message' => 'Promo berhasil dibuat.'];
            
        } catch (Exception $e) {
            $this->transaction->rollbackTransaction();
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    public function updateHargaJual($id, Request $request)
    {
        try {
            $this->transaction->beginTransaction();
            
            $findProduk = $this->produk->findProduk($id);
            $hargaInternal = preg_replace("/[^0-9]/", "", $request->input('harga_internal')) ?: 0;
            $hargaGlobal = preg_replace("/[^0-9]/", "", $request->input('harga_global')) ?: 0;

            if ($findProduk->harga_internal != $hargaInternal) {
                $this->produk->updateProduk($id, ['harga_internal' => $hargaInternal]);
            }

            if ($findProduk->harga_global != $hargaGlobal) {
                $this->produk->updateProduk($id, ['harga_global' => $hargaGlobal]);
            }
            $this->transaction->commitTransaction();
            
        } catch (Exception $e) {
            $this->transaction->rollbackTransaction();
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    public function countModalGudang($id)
    {
        $dataGudangEstimasi = $this->estimasiPart
            ->where('gudang_produk_id', $id)
            ->whereNotNull('tanggal_dikirim')
            ->where('tanggal_dikirim', '!=', '')
            ->where('active', 'Active')
            ->sum('modal_gudang');

        $dataGudangTransaksi = $this->transaksiPart
            ->where('gudang_produk_id', $id)
            ->sum('modal_gudang');

        $dataGudang = $this->sparepart
            ->where('produk_sparepart_id', $id)
            ->whereIn('status', ['Ready', 'Promo'])
            ->first();

        if (!$dataGudang) {
            throw new \Exception("Data gudang tidak ditemukan");
        }

        $dataSubGudang = $dataGudang->produkSparepart->gudangIdItem()->where('status_inventory', 'Ready')->get();
        $totalSN = $dataSubGudang->count();

        if ($totalSN == 0) {
            return ['modalGudang' => 0];
        }

        $modalAwal = $dataGudang->modal_awal ?? 0;
        $modalGudang = ($modalAwal - ($dataGudangEstimasi + $dataGudangTransaksi)) / $totalSN;

        return [
            'modalGudang' => round($modalGudang),
        ];
    }

}