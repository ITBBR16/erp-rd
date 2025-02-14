<?php

namespace App\Repositories\logistik\repository;

use App\Models\ekspedisi\Ekspedisi;
use App\Models\ekspedisi\LogRequest;
use App\Repositories\logistik\interface\LogistikRequestPackingInterface;

class LogistikRequestPackingRepository implements LogistikRequestPackingInterface
{
    public function __construct(
        private LogRequest $logRequest,
        private Ekspedisi $ekspedisi,
    ){}

    public function getDataRequest()
    {
        return $this->logRequest->all();
    }

    public function getEkspedisi()
    {
        return $this->ekspedisi->all();
    }

    public function findEkspedisi($id)
    {
        return $this->ekspedisi->find($id);
    }

    public function findDataRequest($id)
    {
        return $this->logRequest->find($id);
    }

    public function updateRequestPacking($id, array $data)
    {
        $logRequest = $this->logRequest->find($id);
        if ($logRequest) {
            $logRequest->update($data);
            return $logRequest;
        }

        throw new \Exception("Request packing not found.");
    }
}