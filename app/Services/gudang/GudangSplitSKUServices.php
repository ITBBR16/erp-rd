<?php

namespace App\Services\gudang;

use App\Repositories\umum\UmumRepository;
use App\Repositories\umum\repository\ProdukRepository;
use App\Repositories\gudang\repository\GudangProdukRepository;
use App\Repositories\gudang\repository\GudangBelanjaRepository;
use App\Repositories\gudang\repository\GudangProdukIdItemRepository;
use App\Repositories\gudang\repository\GudangTransactionRepository;
use Exception;
use Illuminate\Http\Request;

class GudangSplitSKUServices
{
    public function __construct(
        private UmumRepository $umum,
        private ProdukRepository $produk,
        private GudangTransactionRepository $transaction,
        private GudangProdukRepository $produkGudang,
        private GudangBelanjaRepository $belanja,
        private GudangProdukIdItemRepository $idItem,
    ){}

    public function index()
    {
        $user = auth()->user();
        $divisiName = $this->umum->getDivisi($user);
        $dataProduk = $this->produkGudang->getAllProduk();
        $jenisProduk = $this->produk->getAllJenisProduct();
        $historyPart = $this->idItem->getHistoryPart();

        return view('gudang.produk.split-sku.main-split-sku', [
            'title' => 'Gudang Split SKU',
            'active' => 'gudang-split',
            'navActive' => 'produk',
            'divisi' => $divisiName,
            'dataProduk' => $dataProduk,
            'jenisProduk' => $jenisProduk,
            'historyPart' => $historyPart,
        ]);
    }

    public function createSplit(Request $request)
    {
        try {
            $this->transaction->beginTransaction();

            $idItem = $request->input('id_item');
            $belanjaId = $request->input('belanja_id');
            $nominalAwal = $request->input('nominal_sparepart');

            // Data many
            $splitSparepart = $request->input('sparepart_split');
            $splitNominal = preg_replace("/[^0-9]/", "", $request->input('nominal_split')) ?: 0;
            $splitQty = $request->input('qty_split');

            $historyPart = $this->idItem->createHistoryPart(['gudang_produk_id_item_id' => $idItem, 'nominal' => $nominalAwal]);

            foreach ($splitSparepart as $index => $part) {
                for ($i = 0; $i < $splitQty[$index]; $i++) {
                    $dataSplitIdItem = [
                        'gudang_belanja_id' => $belanjaId,
                        'gudang_produk_id' => $part,
                        'status_inventory' => 'Ready',
                        'produk_asal' => 'Split',
                    ];
                    $resultSplit = $this->idItem->createIdItemBatch($dataSplitIdItem);

                    $dataHistorySplit = [
                        'gudang_history_part_id' => $historyPart->id,
                        'gudang_produk_id_item_id' => $resultSplit->id,
                        'nominal' => $splitNominal[$index],
                    ];
                    $this->idItem->createHistorySplit($dataHistorySplit);
                }
            }

            $this->idItem->updateIdItem($idItem, ['status_inventory' => 'Split']);
            $this->transaction->commitTransaction();
            return ['status' => 'success', 'message' => 'Berhasil melakukan split sparepart'];

        } catch (Exception $e) {
            $this->transaction->rollbackTransaction();
            return ['status' => 'status', 'message' => $e->getMessage()];
        }
    }

    public function getIdItem($idSparepart)
    {
        $findProduk = $this->produkGudang->findBySparepart($idSparepart);
        $sku = $findProduk->produkSparepart->produkType->code . "." . $findProduk->produkSparepart->partModel->code . "." . 
                $findProduk->produkSparepart->produk_jenis_id . "." . $findProduk->produkSparepart->partBagian->code . "." . 
                $findProduk->produkSparepart->partSubBagian->code . "." . $findProduk->produkSparepart->produk_part_sifat_id;
        $listIdItem = $this->produkGudang->getListIdItem($idSparepart);
        return response()->json(['sku' => $sku, 'listIdItem' => $listIdItem]);
    }

    public function getDetailBelanjaSplit($idItem)
    {
        $findIdItem = $this->idItem->findIdItem($idItem);
        $belanjaId = $findIdItem->gudang_belanja_id;
        $produkId = $findIdItem->gudang_produk_id;
        $findDetailBelanja = $this->belanja->getDetailBelanja($belanjaId, $produkId);

        return response()->json($findDetailBelanja);
    }

}