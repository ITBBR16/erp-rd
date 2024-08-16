<?php

namespace App\Repositories\repair\repository;

use App\Models\repair\RepairCase;
use Illuminate\Support\Facades\DB;
use App\Models\repair\RepairEstimasi;
use App\Models\repair\RepairEstimasiJRR;
use App\Models\repair\RepairEstimasiPart;
use App\Repositories\repair\interface\RepairEstimasiInterface;

class RepairTeknisiRepository implements RepairEstimasiInterface
{
    protected $connection, $modelCase, $modelEstimasi, $modelEstimasiPart, $modelEstimasiJrr;
    public function __construct(RepairCase $repairCase, RepairEstimasi $repairEstimasi, RepairEstimasiPart $repairEstimasiPart, RepairEstimasiJRR $repairEstimasiJRR)
    {
        $this->modelCase = $repairCase;
        $this->modelEstimasi = $repairEstimasi;
        $this->modelEstimasiJrr = $repairEstimasiJRR;
        $this->modelEstimasiPart = $repairEstimasiPart;
        $this->connection = DB::connection('rumahdrone_repair');
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

    public function findEstimasi($data, $id)
    {
        $findEstimasi = $this->modelEstimasi->find($id);
        if ($findEstimasi) {
            return $findEstimasi->update($data);
        }

        throw new \Exception('Data Not Found.');
    }
    
    public function createEstimasi(array $data)
    {
        return $this->modelEstimasi->create($data);
    }

    public function createEstimasiPart(array $data)
    {
        return $this->modelEstimasiPart->insert($data);
    }

    public function createEstimasiJrr(array $data)
    {
        return $this->modelEstimasiJrr->insert($data);
    }

}