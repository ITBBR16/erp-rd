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
    protected $modelEkspedisi, $modelLayanan, $connection, $modelLogRequest, $modelLogPenerima;
    public function __construct(Ekspedisi $ekspedisi, JenisPelayanan $jenisPelayanan, LogRequest $logRequest, LogPenerima $logPenerima)
    {
        $this->modelEkspedisi = $ekspedisi;
        $this->modelLayanan = $jenisPelayanan;
        $this->modelLogRequest = $logRequest;
        $this->modelLogPenerima = $logPenerima;
        $this->connection = DB::connection('rumahdrone_ekspedisi');
    }

    public function beginTransaction()
    {
        $this->connection->beginTransaction();
    }

    public function rollbackTransaction()
    {
        $this->connection->rollBack();
    }

    public function commitTransaction()
    {
        $this->connection->commit();
    }

    public function createLogRequest(array $data)
    {
        return $this->modelLogRequest->create($data);
    }

    public function createLogPenerima(array $data)
    {
        return $this->modelLogPenerima->create($data);
    }

    public function getDataEkspedisi()
    {
        return $this->modelEkspedisi->all();
    }

    public function getDataLayanan($id)
    {
        return $this->modelLayanan->where('ekspedisi_id', $id)->get();
    }
}