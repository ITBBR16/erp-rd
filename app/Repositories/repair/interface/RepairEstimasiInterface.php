<?php

namespace App\Repositories\repair\interface;

interface RepairEstimasiInterface
{
    public function getJenisTransaksi();
    public function findEstimasi($id);

    public function createEstimasi(array $data);

    public function createEstimasiChat(array $data);
    public function updateEstimasiChat($data, $id);

    public function createEstimasiPart(array $data);
    public function updateEstimasiPart($data, $id);
    
    public function createEstimasiJrr(array $data);
    public function updateEstimasiJrr($data, $id);
}