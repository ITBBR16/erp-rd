<?php

namespace App\Repositories\gudang\interface;

interface GudangKomplainInterface
{
    public function getDataKomplain();
    public function createKomplain(array $data);
    public function updateKomplain($id, array $data);
}