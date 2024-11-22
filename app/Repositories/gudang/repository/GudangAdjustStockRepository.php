<?php

namespace App\Repositories\gudang\repository;

use App\Models\gudang\GudangAdjustStock;
use App\Repositories\gudang\interface\GudangAdjustStockInterface;

class GudangAdjustStockRepository implements GudangAdjustStockInterface
{
    public function __construct(
        private GudangAdjustStock $adjust
    ){}

    public function getAdjustStock()
    {
        return $this->adjust->all();
    }

    public function createAdjustStock(array $data)
    {
        return $this->adjust->create($data);
    }
}