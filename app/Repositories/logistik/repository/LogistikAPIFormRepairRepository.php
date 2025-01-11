<?php

namespace App\Repositories\logistik\repository;

use App\Models\ekspedisi\DataFormRepair;
use App\Repositories\logistik\interface\LogistikAPIFormRepairInterface;

class LogistikAPIFormRepairRepository implements LogistikAPIFormRepairInterface
{
    public function __construct(
        private DataFormRepair $modelFormRepair
    ){}

    public function createDataFormRepair(array $data)
    {
        return $this->modelFormRepair->create($data);
    }

    public function updateDataFormRepair($id, array $data)
    {
        $formData = $this->modelFormRepair->find($id);
        if ($formData) {
            $formData->update($data);
            return $formData;
        }

        throw new \Exception("Data customer not found.");
    }
}