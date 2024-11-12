<?php

namespace App\Repositories\gudang\repository;

use App\Models\gudang\GudangUnboxing;
use App\Repositories\gudang\interface\GudangUnboxingInterface;

class GudangUnboxingRepository implements GudangUnboxingInterface
{
    public function __construct(
        private GudangUnboxing $unboxing
    ){}

    public function getDataUnboxing()
    {
        return $this->unboxing->all();
    }

    public function createUnboxing(array $data)
    {
        return $this->unboxing->create($data);
    }

    public function updateUnboxing($id, array $data)
    {
        $unboxing = $this->unboxing->find($id);

        if ($unboxing) {
            $unboxing->update($data);
            return $unboxing;
        }

        throw new \Exception("List unboxing not found.");
    }
}