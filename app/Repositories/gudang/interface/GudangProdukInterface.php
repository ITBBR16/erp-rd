<?php

namespace App\Repositories\gudang\interface;

interface GudangProdukInterface
{
    public function getListIdItem($idSparepart);
    public function insertProduk(array $data);
}