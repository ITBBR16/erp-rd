<?php

namespace App\Repositories\gudang\interface;

interface GudangSupplierInterface
{
    public function getSuppliers();
    
    public function createSupplier(array $data);
    public function updateSupplier($id, array $data);
    public function deactiveSupplier($id);
    public function activeSupplier($id);
}