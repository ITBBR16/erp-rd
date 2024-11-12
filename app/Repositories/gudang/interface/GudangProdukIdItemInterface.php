<?php

namespace App\Repositories\gudang\interface;

interface GudangProdukIdItemInterface
{
    public function createIdItem(array $data);
    public function updateIdItem($id, array $data);
}