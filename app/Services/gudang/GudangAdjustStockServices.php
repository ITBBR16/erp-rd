<?php

namespace App\Services\gudang;

use App\Repositories\gudang\repository\GudangAdjustStockRepository;
use App\Repositories\gudang\repository\GudangProdukIdItemRepository;
use App\Repositories\gudang\repository\GudangTransactionRepository;
use App\Repositories\umum\repository\ProdukRepository;
use App\Repositories\umum\UmumRepository;
use Exception;
use Illuminate\Http\Request;

class GudangAdjustStockServices
{
    public function __construct(
        private UmumRepository $umum,
        private ProdukRepository $produk,
        private GudangTransactionRepository $transaction,
        private GudangAdjustStockRepository $adjust,
        private GudangProdukIdItemRepository $idItem
    ){}

    public function index()
    {
        $user = auth()->user();
        $divisiName = $this->umum->getDivisi($user);
        $jenisProduk = $this->produk->getAllJenisProduct();
        $historyAdjust = $this->adjust->getAdjustStock();

        return view('gudang.produk.adjust-stock.main-adjust', [
            'title' => 'Gudang Adjust Stock',
            'active' => 'gudang-adjust',
            'navActive' => 'produk',
            'divisi' => $divisiName,
            'jenisProduk' => $jenisProduk,
            'historyAdjust' => $historyAdjust
        ]);
    }

    public function storeAdjustStock(Request $request)
    {
        try {
            $this->transaction->beginTransaction();

            $employeeId = auth()->user()->id;
            $idItem = $request->input('id_item');
            $statusAdjust = $request->input('status_adjust');
            $keterangan = $request->input('keterangan');

            $dataAdjust = [
                'employee_id' => $employeeId,
                'gudang_produk_id_item_id' => $idItem,
                'keterangan' => $keterangan,
                'status' => $statusAdjust,
            ];

            if ($statusAdjust == 'Kurang') {
                $this->idItem->updateIdItem($idItem, ['status_inventory' => 'Adjusted']);
                // Request ke akuntan untuk melakukan penyesuaian persediaan
            } elseif ($statusAdjust == 'Lebih') {
                // Jika ada lebih apakah menambahkan di gudang dan akuntan? dan pertanyaan jika ada atau tidak identitasnya
            } else {
                $this->transaction->rollbackTransaction();
                return ['status' => 'error', 'message' => 'Status adjust tidak terifentifikasi.'];
            }

            $this->adjust->createAdjustStock($dataAdjust);
            $this->transaction->commitTransaction();

            return ['status' => 'success', 'message' => 'Adjust stock berhasil dilakukan'];

        } catch (Exception $e) {
            $this->transaction->rollbackTransaction();
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }
}