<?php

namespace App\Repositories\logistik\repository;

use App\Models\ekspedisi\LogRequest;
use App\Repositories\logistik\interface\LogistikRequestPackingInterface;

class LogistikRequestPackingRepository implements LogistikRequestPackingInterface
{
    public function __construct(
        private LogRequest $logRequest
    ){}

    public function getDataRequest()
    {
        return $this->logRequest->all();
    }

    public function findDataRequest($id)
    {
        return $this->logRequest->find($id);
    }
}