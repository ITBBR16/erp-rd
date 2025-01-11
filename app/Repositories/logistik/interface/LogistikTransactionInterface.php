<?php

namespace App\Repositories\logistik\interface;

interface LogistikTransactionInterface
{
    public function beginTransaction();
    public function commitTransaction();
    public function rollbackTransaction();
}