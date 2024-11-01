<?php

namespace App\Repositories\umum\repository;

use App\Models\produk\ProdukJenis;
use App\Models\produk\ProdukSparepart;
use App\Repositories\umum\interface\ProdukInterface;

class ProdukRepository implements ProdukInterface
{
    public function __construct(
        private ProdukJenis $produkJenis,
        private ProdukSparepart $sparepart
    ){}

    public function getAllJenisProduct()
    {
        return $this->produkJenis->all();
    }

    public function findJenisProduct($id)
    {
        return $this->produkJenis->find($id);
    }

    public function getSparepartbyJenis($id)
    {
        return $this->sparepart->where('produk_jenis_id', $id)->get();
    }
}