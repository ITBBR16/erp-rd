<?php

namespace App\Repositories\repair\repository;

use App\Models\repair\RepairCase;
use Illuminate\Support\Facades\DB;
use App\Repositories\repair\interface\RepairTeknisiInterface;

class RepairTeknisiRepository implements RepairTeknisiInterface
{
    protected $model, $connection;

    public function __construct(RepairCase $case)
    {
        $this->model = $case;
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

    public function ambilCaseTeknisi($id, array $data)
    {
        $ambilCase = $this->model->findOrFail($id);
        if ($ambilCase) {
            $ambilCase->update($data);
            return $ambilCase;
        }

        throw new \Exception('Case Not Found');
    }

}
