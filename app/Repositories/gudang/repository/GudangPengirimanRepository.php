<?php

namespace App\Repositories\gudang\repository;

use App\Models\gudang\GudangPengiriman;
use App\Repositories\gudang\interface\GudangPengirimanInterface;

class GudangPengirimanRepository implements GudangPengirimanInterface
{
    public function __construct(
        private GudangPengiriman $pengiriman
    ){}

    public function createPengiriman(array $data)
    {
        return $this->pengiriman->create($data);
    }

    public function updatePengiriman($id, array $data)
    {
        $pengiriman = $this->pengiriman->find($id);

        if ($pengiriman) {
            $pengiriman->update($data);
            return $pengiriman;
        }

        throw new \Exception("Pengiriman not found.");
    }

    public function findPengiriman($id)
    {
        return $this->pengiriman->find($id);
    }

    public function getPengiriman()
    {
        return $this->pengiriman->all();
    }
}