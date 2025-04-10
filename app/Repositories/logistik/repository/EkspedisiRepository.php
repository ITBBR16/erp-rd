<?php

namespace App\Repositories\logistik\repository;

use Illuminate\Support\Facades\DB;
use App\Models\ekspedisi\Ekspedisi;
use App\Models\ekspedisi\JenisPelayanan;
use App\Models\ekspedisi\LogPenerima;
use App\Models\ekspedisi\LogRequest;
use App\Repositories\logistik\interface\EkspedisiInterface;

class EkspedisiRepository implements EkspedisiInterface
{
    public function __construct(
        private Ekspedisi $modelEkspedisi,
        private JenisPelayanan $modelLayanan,
        private LogRequest $modelLogRequest,
        private LogPenerima $modelLogPenerima)
    {}

    public function createLogRequest(array $data)
    {
        return $this->modelLogRequest->create($data);
    }

    public function updateLogRequest($id, array $data)
    {
        $logReq = $this->modelLogRequest->find($id);
        if ($logReq) {
            $logReq->update($data);
            return $logReq;
        }

        throw new \Exception("Case not found.");
    }

    public function createLogPenerima(array $data)
    {
        return $this->modelLogPenerima->create($data);
    }

    public function getDataEkspedisi()
    {
        return $this->modelEkspedisi->all();
    }

    public function getLayananEkspedisi()
    {
        return $this->modelLayanan->all();
    }

    public function getDataLayanan($id)
    {
        return $this->modelLayanan->where('ekspedisi_id', $id)->get();
    }
}