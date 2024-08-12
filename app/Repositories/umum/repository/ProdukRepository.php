<?php

namespace App\Repositories\umum\repository;

use App\Models\produk\ProdukJenis;
use App\Repositories\umum\interface\ProdukInterface;

class ProdukRepository implements ProdukInterface
{
    protected $model;

    public function __construct(ProdukJenis $produkJenis)
    {
        $this->model = $produkJenis;
    }

    public function getAllProduct()
    {
        return $this->model->all();
    }

    public function findProduct($id)
    {
        return $this->model->findOrFail($id);
    }
}