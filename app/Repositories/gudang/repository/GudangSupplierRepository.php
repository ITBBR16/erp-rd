<?php

namespace App\Repositories\gudang\repository;

use App\Models\gudang\GudangSupplier;
use App\Repositories\gudang\interface\GudangSupplierInterface;

class GudangSupplierRepository implements GudangSupplierInterface
{
    public function __construct(
        private GudangSupplier $supplier
    ){}

    public function getSuppliers()
    {
        return $this->supplier->all();
    }

    public function createSupplier(array $data)
    {
        return $this->supplier->create($data);
    }

    public function updateSupplier($id, array $data)
    {
        $supplier = $this->supplier->find($id);
        if ($supplier) {
            $supplier->update($data);
            return $supplier;
        }

        throw new \Exception("Supplier not found.");
    }

    public function deactiveSupplier($id)
    {
        $supplier = $this->supplier->find($id);
        if ($supplier) {
            $supplier->update(['status' => 'Deactive']);
            return $supplier;
        }

        throw new \Exception("Supplier not found.");
    }
    
    public function activeSupplier($id)
    {
        $supplier = $this->supplier->find($id);
        if ($supplier) {
            $supplier->update(['status' => 'Active']);
            return $supplier;
        }

        throw new \Exception("Supplier not found.");
    }
}