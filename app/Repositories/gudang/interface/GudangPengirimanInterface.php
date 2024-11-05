<?php

namespace App\Repositories\gudang\interface;

interface GudangPengirimanInterface
{
    public function createPengiriman(array $data);
    public function findPengiriman($id);
    public function getPengiriman();
}