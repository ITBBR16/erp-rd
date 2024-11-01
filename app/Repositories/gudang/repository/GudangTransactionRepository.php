<?php

namespace App\Repositories\gudang\repository;

use App\Repositories\gudang\interface\GudangTransactionInterface;
use Illuminate\Support\Facades\DB;

class GudangTransactionRepository implements GudangTransactionInterface
{
    protected $model, $connection;

    public function __construct()
    {
        $this->connection = DB::connection('rumahdrone_gudang');
    }

    public function beginTransaction()
    {
        $this->connection->beginTransaction();
    }

    public function commitTransaction()
    {
        $this->connection->commit();
    }

    public function rollbackTransaction()
    {
        $this->connection->rollBack();
    }
}