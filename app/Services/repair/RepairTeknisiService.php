<?php

namespace App\Services\repair;

use App\Repositories\repair\repository\RepairTeknisiRepository;
use App\Repositories\repair\repository\RepairTimeJurnalRepository;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;

class RepairTeknisiService
{
    protected $repairTeknisi, $repairTimeJurnal;

    public function __construct(RepairTeknisiRepository $repairTeknisiRepository, RepairTimeJurnalRepository $repairTimeJurnal)
    {
        $this->repairTeknisi = $repairTeknisiRepository;
        $this->repairTimeJurnal = $repairTimeJurnal;
    }

    public function ambilCase($id)
    {
        $this->repairTeknisi->beginTransaction();
        $teknisiId = auth()->user()->id;

        try {
            $dataUpdate = [
                'jenis_status_id' => 2,
                'teknisi_id' => $teknisiId
            ];

            $this->repairTeknisi->updateStatusCase($id, $dataUpdate);

            $this->repairTeknisi->commitTransaction();
            return ['status' => 'success', 'message' => 'Berhasil mengambil case baru.'];
        } catch (Exception $e) {
            $this->repairTeknisi->rollBackTransaction();
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    public function createJurnal(Request $request, $id)
    {
        $this->repairTeknisi->beginTransaction();
        $employeeId = auth()->user()->id;

        try {
            $tglWaktu = Carbon::now();
            $jurnalTS = $request->input('jurnal_troubleshooting');
            $imgTS = $request->input('files_troubleshooting');

            $checkTimestamp = $this->repairTimeJurnal->findTimestime($id, 2);

            if ($checkTimestamp) {
                $timestamp = $checkTimestamp;
            } else {
                $dataTimestamp = [
                    'case_id' => $id,
                    'jenis_status_id' => 2,
                    'tanggal_waktu' => $tglWaktu,
                ];
    
                $timestamp = $this->repairTimeJurnal->createTimestamp($dataTimestamp);
            }

            $dataJurnal = [
                'employee_id' => $employeeId,
                'jenis_substatus_id' => 1,
                'timestamps_status_id' => $timestamp->id,
                'isi_jurnal' => $jurnalTS,
            ];

            $this->repairTimeJurnal->addJurnal($dataJurnal);

            $this->repairTeknisi->commitTransaction();
            return ['status' => 'success', 'message' => 'Berhasil membuat jurnal baru.'];

        } catch (Exception $e) {
            $this->repairTeknisi->rollBackTransaction();
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    public function changeStatus($id)
    {
        $this->repairTeknisi->beginTransaction();
        $employeeId = auth()->user()->id;

        try {
            $tglWaktu = Carbon::now();

            $dataTimestamp = [
                'case_id' => $id,
                'jenis_status_id' => 3,
                'tanggal_waktu' => $tglWaktu,
            ];
            $timestamp = $this->repairTimeJurnal->createTimestamp($dataTimestamp);

            $dataJurnal = [
                'employee_id' => $employeeId,
                'jenis_substatus_id' => 1,
                'timestamps_status_id' => $timestamp->id,
                'isi_jurnal' => 'Ganti status to Estimasi',
            ];

            $this->repairTimeJurnal->addJurnal($dataJurnal);

            $dataUpdate = [
                'jenis_status_id' => 3,
            ];

            $this->repairTeknisi->updateStatusCase($id, $dataUpdate);

            $this->repairTeknisi->commitTransaction();
            return ['status' => 'success', 'message' => 'Berhasil lanjut ke estimasi biaya.'];

        } catch (Exception $e) {
            $this->repairTeknisi->rollBackTransaction();
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }
}