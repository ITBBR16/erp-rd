<?php

namespace App\Repositories\gudang\repository;

use App\Models\produk\ProdukJenis;
use App\Models\produk\ProdukPartBagian;
use App\Models\produk\ProdukPartModel;
use App\Models\produk\ProdukPartSifat;
use App\Models\produk\ProdukPartSubBagian;
use App\Models\produk\ProdukSparepart;
use App\Models\produk\ProdukType;
use App\Repositories\gudang\interface\GudangAddNewSparepartInterface;

class GudangAddNewSparepartRepository implements GudangAddNewSparepartInterface
{
    public function __construct(
        private ProdukSparepart $sparepart,
        private ProdukType $type,
        private ProdukPartModel $model,
        private ProdukJenis $jenis,
        private ProdukPartBagian $bagian,
        private ProdukPartSubBagian $subBagian,
        private ProdukPartSifat $sifat

    ){}

    public function getTypePart()
    {
        return $this->type->all();
    }

    public function getModelPart()
    {
        return $this->model->all();
    }

    public function getBagianPart()
    {
        return $this->bagian->all();
    }

    public function getSubBagianPart()
    {
        return $this->subBagian->all();
    }

    public function getSifatPart()
    {
        return $this->sifat->all();
    }

    public function createNewSparepart(array $data)
    {
        return $this->sparepart->create($data);
    }

    public function insertSparepart(array $data)
    {
        return $this->sparepart->insert($data);
    }
}