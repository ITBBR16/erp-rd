<?php

namespace App\Repositories\gudang\interface;

interface GudangQualityControllInterface
{
    public function createQc(array $data);
    public function insertQc(array $data);
    public function updateQc($id, array $data);
}