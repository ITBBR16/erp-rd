<?php

namespace App\Repositories\repair\interface;

interface RepairQCInterface
{
    public function createQc(array $data);
    public function updateQc($id, array $data);
    
    public function createQcFisik(array $data);
    public function createQcCalibrasi(array $data);
    public function createQcTestFly(array $data);
}
