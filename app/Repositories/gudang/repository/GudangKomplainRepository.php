<?php

namespace App\Repositories\gudang\repository;

use App\Models\gudang\GudangKomplain;
use App\Repositories\gudang\interface\GudangKomplainInterface;

class GudangKomplainRepository implements GudangKomplainInterface
{
    public function __construct(
        private GudangKomplain $komplain
    ){}

    public function getDataKomplain()
    {
        return $this->komplain->all();
    }

    public function createKomplain(array $data)
    {
        return $this->komplain->create($data);
    }

    public function updateKomplain($id, array $data)
    {
        $komplain = $this->komplain->find($id);

        if ($komplain) {
            $komplain->update($data);
            return $komplain;
        }

        throw new \Exception('Data komplain not found.');
    }
}