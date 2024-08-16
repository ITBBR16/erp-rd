<?php

namespace App\Repositories\repair\interface;

interface RepairEstimasiInterface
{
    public function findEstimasi($data, $id);

    public function createEstimasi(array $data);
    public function createEstimasiPart(array $data);
    public function createEstimasiJrr(array $data);
}