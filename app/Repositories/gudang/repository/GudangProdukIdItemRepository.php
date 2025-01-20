<?php

namespace App\Repositories\gudang\repository;

use App\Models\gudang\GudangHistoryPart;
use App\Models\gudang\GudangHistorySplit;
use App\Models\gudang\GudangProdukIdItem;
use App\Repositories\gudang\interface\GudangProdukIdItemInterface;

class GudangProdukIdItemRepository implements GudangProdukIdItemInterface
{
    public function __construct(
        private GudangProdukIdItem $idPart,
        private GudangHistoryPart $historyPart,
        private GudangHistorySplit $historySplit,
    ){}

    public function getListProdukIdItem()
    {
        return $this->idPart
                ->with('qualityControll')
                ->whereHas('qualityControll', function ($query) {
                    $query->where('status_qc', '!=', 'Tervalidasi');
                })
                ->get();
    }

    public function getProdukForQc($idBelanja, $idProduk)
    {
        return $this->idPart->where('gudang_belanja_id', $idBelanja)->where('gudang_produk_id', $idProduk)->get();
    }

    public function getHistoryPart()
    {
        return $this->historyPart->all();
    }

    public function findIdItem($id)
    {
        return $this->idPart->find($id);
    }

    public function createIdItemBatch(array $data)
    {
        return $this->idPart->create($data);
    }

    public function insertIdItem(array $data)
    {
        $insertedIds = [];

        foreach ($data as $item) {
            $insertedIds[] = $this->idPart->insertGetId($item);
        }

        return $insertedIds;
    }

    public function updateIdItem($id, array $data)
    {
        $idItem = $this->idPart->find($id);

        if ($idItem) {
            $idItem->update($data);
            return $idItem;
        }

        throw new \Exception('Id item not found.');
    }

    public function createHistoryPart(array $data)
    {
        return $this->historyPart->create($data);
    }

    public function createHistorySplit(array $data)
    {
        return $this->historySplit->create($data);
    }
}