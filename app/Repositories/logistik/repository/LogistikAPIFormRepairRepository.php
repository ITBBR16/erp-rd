<?php

namespace App\Repositories\logistik\repository;

use App\Models\ekspedisi\DataFormRepair;
use App\Repositories\logistik\interface\LogistikAPIFormRepairInterface;

class LogistikAPIFormRepairRepository implements LogistikAPIFormRepairInterface
{
    public function __construct(
        private DataFormRepair $modelFormRepair
    ){}

    public function getDataForm()
    {
        return $this->modelFormRepair->all();
    }

    public function createDataFormRepair(array $data)
    {
        return $this->modelFormRepair->create($data);
    }

    public function updateDataFormRepair($id, array $data)
    {
        $formData = $this->modelFormRepair->where('no_register', $id)->first();
        if ($formData) {
            $formData->update($data);
            return $formData;
        }

        throw new \Exception("Data customer not found.");
    }

    public function findRegister($id)
    {
        return $this->modelFormRepair->where('no_register', $id)->first();
    }
}