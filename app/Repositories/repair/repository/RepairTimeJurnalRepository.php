<?php

namespace App\Repositories\repair\repository;

use Illuminate\Support\Facades\DB;
use App\Models\repair\RepairJurnal;
use App\Models\repair\RepairTimestampStatus;
use App\Repositories\repair\interface\RepairTimeJurnalInterface;

class RepairTimeJurnalRepository implements RepairTimeJurnalInterface
{
    protected $connection, $modelJurnal, $modelTimestamp;

    public function __construct(RepairTimestampStatus $timeStamp, RepairJurnal $jurnal)
    {
        $this->modelJurnal = $jurnal;
        $this->modelTimestamp = $timeStamp;
        $this->connection = DB::connection('rumahdrone_repair');
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