<?php

namespace App\Repositories\umum\interface;

interface ProdukInterface
{
    public function getAllProduct();
    public function findProduct($id);
}