<?php

namespace App\Repositories\gudang\repository;

use App\Models\gudang\GudangProdukIdItem;
use App\Repositories\gudang\interface\GudangProdukIdItemInterface;

class GudangProdukIdItemRepository implements GudangProdukIdItemInterface
{
    public function __construct(
        private GudangProdukIdItem $idPart
    ){}

    public function getListProdukIdItem()
    {
        return $this->idPart->all();
    }

    public function getProdukForQc($idBelanja, $idProduk)
    {
        return $this->idPart->where('gudang_belanja_id', $idBelanja)->where('gudang_produk_id', $idProduk)->get();
    }

    public function createIdItem(array $data)
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
}