<?php

namespace App\Repositories\logistik\repository;

use Illuminate\Support\Facades\DB;
use App\Repositories\logistik\interface\LogistikTransactionInterface;

class LogistikTransactionRepository implements LogistikTransactionInterface
{
    protected $connection;

    public function __construct()
    {
        $this->connection = DB::connection('rumahdrone_ekspedisi');
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