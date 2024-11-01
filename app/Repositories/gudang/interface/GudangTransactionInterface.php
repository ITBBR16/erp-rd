<?php

namespace App\Repositories\gudang\interface;

interface GudangTransactionInterface
{
    public function beginTransaction();
    public function commitTransaction();
    public function rollbackTransaction();
}