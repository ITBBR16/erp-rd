<?php

namespace App\Repositories\gudang\repository;

use App\Models\gudang\GudangQualityControll;
use App\Repositories\gudang\interface\GudangQualityControllInterface;

class GudangQualityControllRepository implements GudangQualityControllInterface
{
    public function __construct(
        private GudangQualityControll $qc
    ){}

    public function createQc(array $data)
    {
        return $this->qc->create($data);
    }

    public function insertQc(array $data)
    {
        return $this->qc->insert($data);
    }

    public function updateQc($id, array $data)
    {
        $qc = $this->qc->where('gudang_produk_id_item_id', $id);

        if ($qc) {
            $qc->update($data);
            return $qc;
        }

        throw new \Exception('Quality control not found.');
    }
}