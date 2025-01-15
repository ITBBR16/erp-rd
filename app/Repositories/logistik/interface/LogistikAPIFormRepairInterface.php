<?php

namespace App\Repositories\logistik\interface;

interface LogistikAPIFormRepairInterface
{
    public function getDataForm();
    public function createDataFormRepair(array $data);
    public function updateDataFormRepair($id, array $data);
    public function findRegister($id);
}