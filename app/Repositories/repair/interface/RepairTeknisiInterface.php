<?php

namespace App\Repositories\repair\interface;

interface RepairTeknisiInterface
{
    public function findCase($id);
    public function updateStatusCase($id, array $data);
}