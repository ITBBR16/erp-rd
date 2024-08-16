<?php

namespace App\Repositories\repair\repository;

use App\Models\repair\RepairCase;
use App\Models\repair\RepairJurnal;
use App\Models\repair\RepairTimestampStatus;
use Illuminate\Support\Facades\DB;
use App\Repositories\repair\interface\RepairTeknisiInterface;

class RepairTeknisiRepository implements RepairTeknisiInterface
{
    protected $model, $modelTimestamp, $modelJurnal, $connection;

    public function __construct(RepairCase $case, RepairTimestampStatus $timeStamp, RepairJurnal $jurnal)
    {
        $this->model = $case;
        $this->modelJurnal = $jurnal;
        $this->modelTimestamp = $timeStamp;
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

    public function rollBackTransaction()
    {
        $this->connection->rollBack();
    }

    public function findCase($id)
    {
        $findCase = $this->model->findOrFail($id);
        
        if ($findCase) {
            return $findCase;
        }

        throw new \Exception('Case Not Found.');
    }

    public function updateStatusCase($id, array $data)
    {
        $searchCase = $this->model->findOrFail($id);
        if ($searchCase) {
            $searchCase->update($data);
            return $searchCase;
        }

        throw new \Exception('Case Not Found');
    }

    public function createTimestamp(array $data)
    {
        return $this->modelTimestamp->create($data);
    }

    public function findTimestime($caseId, $statusId)
    {
        return $this->modelTimestamp->where('case_id', $caseId)
                                    ->where('jenis_status_id', $statusId)
                                    ->first();
    }

    public function addJurnal(array $data)
    {
        return $this->modelJurnal->create($data);
    }

}
