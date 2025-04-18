<?php

namespace App\Repositories\gudang\interface;

interface GudangBelanjaInterface
{
    public function createMetodePembayaran(array $data);
    public function createBelanja(array $dataBelanja, array $detailBelanja);
    public function updateBelanja($belanja, array $belanjaData);
    public function updateBelanjaDetails($belanja, array $detailData);
    public function deleteBelanja($id);

    public function indexBelanja();
    public function findBelanja($id);
}