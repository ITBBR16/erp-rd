<?php

namespace App\Repositories\repair\repository;

use App\Models\repair\RepairCase;
use App\Models\repair\RepairJenisCase;
use App\Models\repair\RepairJenisFungsional;
use App\Models\repair\RepairKelengkapan;
use Illuminate\Support\Facades\DB;
use App\Repositories\repair\interface\RepairCaseInterface;

class RepairCaseRepository implements RepairCaseInterface
{
    protected $modelCase, $modelFungsional, $modelJenisCase, $modelRepairKelengkapan, $connection;

    public function __construct(RepairCase $case, RepairJenisFungsional $repairJenisFungsional, RepairJenisCase $repairJenisCase, RepairKelengkapan $repairKelengkapan)
    {
        $this->modelCase = $case;
        $this->modelFungsional = $repairJenisFungsional;
        $this->modelJenisCase = $repairJenisCase;
        $this->modelRepairKelengkapan = $repairKelengkapan;
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

    public function createNewCase(array $data)
    {
        return $this->modelCase->create($data);
    }

    public function findCase($id)
    {
        return $this->modelCase->findOrFail($id);
    }

    public function updateCase($id, array $data)
    {
        $case = $this->modelCase->find($id);
        if ($case) {
            $case->update($data);
            return $case;
        }

        throw new \Exception("Case not found.");
    }

    public function createDetailKelengkapan(array $data)
    {
        return $this->modelRepairKelengkapan->insert($data);
    }

    public function getAllDataNeededNewCase()
    {
        return [
            'data_case' => $this->modelCase->all(),
            'jenis_case' => $this->modelJenisCase->all(),
            'fungsional_drone' => $this->modelFungsional->all(),
        ];
    }

}
