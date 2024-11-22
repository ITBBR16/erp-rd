<?php

namespace App\Repositories\gudang\interface;

interface GudangProdukIdItemInterface
{
    public function createIdItemBatch(array $data);
    public function updateIdItem($id, array $data);
}