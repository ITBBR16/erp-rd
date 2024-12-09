<?php

namespace App\Repositories\repair\repository;

use Illuminate\Support\Facades\DB;
use App\Models\repair\RepairQCFisik;
use App\Models\repair\RepairQCKondisi;
use App\Models\repair\RepairQCTestFly;
use App\Models\repair\RepairQCKategori;
use App\Models\repair\RepairQCCalibrasi;
use App\Models\repair\RepairQualityControl;
use App\Repositories\repair\interface\RepairQCInterface;

class RepairQCRepository implements RepairQCInterface
{
    protected $connection;
    public function __construct(
        private RepairQualityControl $modelQc,
        private RepairQCFisik $modelQcFisik,
        private RepairQCCalibrasi $modelQcCalibrasi,
        private RepairQCTestFly $modelQcTestFly,
        private RepairQCKategori $modelQcKategori,
        private RepairQCKondisi $modelQcKondisi)
    {
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

    public function findQualityControl($caseId)
    {
        return $this->modelQc->where('case_id', $caseId)->first();
    }

    public function createQc(array $data)
    {
        return $this->modelQc->create($data);
    }

    public function updateQc($id, array $data)
    {
        $findQc = $this->modelQc->find($id);

        if ($findQc) {
            $findQc->update($data);
            return $findQc;
        }

        throw new \Exception('Quality Control Not Found.');
    }

    public function createQcFisik(array $data)
    {
        return $this->modelQcFisik->create($data);
    }

    public function createQcCalibrasi(array $data)
    {
        return $this->modelQcCalibrasi->create($data);
    }

    public function createQcTestFly(array $data)
    {
        return $this->modelQcTestFly->create($data);
    }

    public function getAllData()
    {
        return [
            'kategori' => $this->modelQcKategori->all(),
            'kondisi' => $this->modelQcKondisi->all(),
        ];
    }

}