<?php

namespace App\Repositories\logistik\repository;

use App\Models\ekspedisi\LogCase;
use App\Models\ekspedisi\Ekspedisi;
use App\Models\ekspedisi\LogRequest;
use App\Models\ekspedisi\LogPenerima;
use App\Models\ekspedisi\LogPenerimaKelengkapan;
use App\Repositories\logistik\interface\LogistikRequestPackingInterface;

class LogistikRequestPackingRepository implements LogistikRequestPackingInterface
{
    public function __construct(
        private LogRequest $logRequest,
        private Ekspedisi $ekspedisi,
        private LogCase $logCase,
        private LogPenerima $logPenerima,
        private LogPenerimaKelengkapan $logKelengkapan,
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

    public function findPenerimaById($id)
    {
        return $this->logPenerima->find($id);
    }

    public function createLogRequest(array $data)
    {
        return $this->logRequest->create($data);
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

    public function createLogPenerima(array $data)
    {
        return $this->logPenerima->create($data);
    }

    public function createLogCase(array $data)
    {
        return $this->logCase->create($data);
    }

    public function createLogKelengkapan(array $data)
    {
        return $this->logKelengkapan->create($data);
    }
}