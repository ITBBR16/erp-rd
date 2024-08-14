<?php

namespace App\Services\repair;

use App\Repositories\repair\repository\RepairTeknisiRepository;
use Exception;
use Illuminate\Http\Request;

class RepairTeknisiService
{
    protected $repairCase;

    public function __construct(RepairTeknisiRepository $repairTeknisiRepository)
    {
        $this->repairCase = $repairTeknisiRepository;
    }

    public function ambilCase($id)
    {
        $this->repairCase->beginTransaction();
        $teknisiId = auth()->user()->id;

        try {
            $dataUpdate = [
                'jenis_status_id' => 2,
                'teknisi_id' => $teknisiId
            ];

            $this->repairCase->ambilCaseTeknisi($id, $dataUpdate);

            $this->repairCase->commitTransaction();
            return ['status' => 'success', 'message' => 'Berhasil mengambil case baru.'];
        } catch (Exception $e) {
            $this->repairCase->rollBackTransaction();
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }
}