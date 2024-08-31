<?php

namespace App\Services\repair;

use App\Repositories\repair\repository\RepairCaseRepository;
use Exception;
use Illuminate\Http\Request;
use App\Repositories\repair\repository\RepairQCRepository;
use App\Repositories\repair\repository\RepairTimeJurnalRepository;
use Carbon\Carbon;

class RepairQCService
{
    protected $repairQc, $repairTimeJurnal, $repairCase;

    public function __construct(RepairQCRepository $repairQCRepository, RepairTimeJurnalRepository $repairTimeJurnal, RepairCaseRepository $repairCase)
    {
        $this->repairCase = $repairCase;
        $this->repairQc = $repairQCRepository;
        $this->repairTimeJurnal = $repairTimeJurnal;
    }

    public function getDataNeed()
    {
        $dataDD = $this->repairQc->getAllData();
        return [
            'kategori' => $dataDD['kategori'],
            'kondisi' => $dataDD['kondisi'],
        ];
    }

    public function changeStatus(Request $request, $id)
    {
        $this->repairQc->beginTransaction();
        $employeeId = auth()->user()->id;

        try {
            $tglWaktu = Carbon::now();
            
            $dataTimestamp = [
                'case_id' => $id,
                'jenis_status_id' => 8,
                'tanggal_waktu' => $tglWaktu,
            ];
            $timestamp = $this->repairTimeJurnal->createTimestamp($dataTimestamp);

            $dataJurnal = [
                'employee_id' => $employeeId,
                'jenis_substatus_id' => 1,
                'timestamps_status_id' => $timestamp->id,
                'isi_jurnal' => 'Ganti status to Konfirmasi Hasil QC',
            ];
            $this->repairTimeJurnal->addJurnal($dataJurnal);

            $dataUpdateCase = ['jenis_status_id' => 8];
            $this->repairCase->updateCase($id, $dataUpdateCase);

            $this->repairQc->commitTransaction();
            return ['status' => 'success', 'message' => 'Berhasil pindah status to konfirmasi hasil QC.'];

        } catch (Exception $e) {
            $this->repairQc->rollbackTransaction();
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    public function createQcFisik(Request $request)
    {
        $this->repairQc->beginTransaction();

        try {
            $employeeId = auth()->user()->id;
            $caseId = $request->input('case_id');
            $cekFisik = $request->input('cek_fisik');
            $kondisiFisik = $request->input('kondisi_fisik');
            $keteranganFisik = $request->input('keterangan_fisik');
            $checkboxQcFisik = $request->input('checkbox_qc_fisik');

            $checkQC = $this->repairQc->findQualityControl($caseId);

            if ($checkQC) {
                $resultQc = $checkQC;
            } else {
                $dataQc = [
                    'case_id' => $caseId,
                ];

                $resultQc = $this->repairQc->createQc($dataQc);
            }

            foreach ($cekFisik as $index => $item) {
                $listCheck = in_array($item, $checkboxQcFisik) ? 1 : 0;
                $dataCekFisik = [
                    'employee_id' => $employeeId,
                    'qc_id' => $resultQc->id,
                    'kategori_cek_id' => $item,
                    'check' => $listCheck,
                    'kondisi_id' => $kondisiFisik[$index],
                    'keterangan' => $keteranganFisik[$index],
                ];

                $this->repairQc->createQcFisik($dataCekFisik);
            }

            $this->repairQc->commitTransaction();
            return ['status' => 'success', 'message' => 'Berhasil membuat quality control fisik baru.'];

        } catch (Exception $e) {
            $this->repairQc->rollbackTransaction();
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    public function createCalibrasi(Request $request)
    {
        $this->repairQc->beginTransaction();

        try {
            $employeeId = auth()->user()->id;
            $caseId = $request->input('case_id');
            $cekCalibrasi = $request->input('cek_calibrasi');
            $checkboxCalibrasi = $request->input('checkbox_qc_calibrasi');
            $keteranganCalibrasi = $request->input('keterangan_calibrasi');
            $fvAircraft = $request->input('fv_aircraft');
            $fvRc = $request->input('fv_rc');
            $fvBattery = $request->input('fv_battery');

            $checkQC = $this->repairQc->findQualityControl($caseId);

            if ($checkQC) {
                $resultQc = $checkQC;
                $dataUpdateQc = [
                    'fv_aircraft' => $fvAircraft,
                    'fv_rc' => $fvRc,
                    'fv_battery' => $fvBattery,
                ];

                $this->repairQc->updateQc($resultQc->id, $dataUpdateQc);

            } else {
                $dataQc = [
                    'case_id' => $caseId,
                    'fv_aircraft' => $fvAircraft,
                    'fv_rc' => $fvRc,
                    'fv_battery' => $fvBattery,
                ];

                $resultQc = $this->repairQc->createQc($dataQc);
            }

            foreach ($cekCalibrasi as $index => $item) {
                $listCheck = in_array($item, $checkboxCalibrasi) ? 1 : 0;
                $dataCekCalibrasi = [
                    'employee_id' => $employeeId,
                    'qc_id' => $resultQc->id,
                    'kategori_cek_id' => $item,
                    'check' => $listCheck,
                    'keterangan' => $keteranganCalibrasi[$index],
                ];

                $this->repairQc->createQcCalibrasi($dataCekCalibrasi);
            }

            $this->repairQc->commitTransaction();
            return ['status' => 'success', 'message' => 'Berhasil membuat quality control calibrasi baru. '];

        } catch (Exception $e) {
            $this->repairQc->rollbackTransaction();
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    public function createTestFly(Request $request)
    {
        $this->repairQc->beginTransaction();

        try {
            $employeeId = auth()->user()->id;
            $caseId = $request->input('case_id');
            $cekTestfly = $request->input('cek_testfly');
            $checkboxTestfly = $request->input('checkbox_testfly');
            $keteranganTestfly = $request->input('keterangan_testfly');
            $kesimpulanTestFly = $request->input('kesimpulan');

            $checkQC = $this->repairQc->findQualityControl($caseId);

            if ($checkQC) {
                $resultQc = $checkQC;
                $dataUpdateQc = [
                    'kesimpulan' => $kesimpulanTestFly,
                ];

                $this->repairQc->updateQc($resultQc->id, $dataUpdateQc);

            } else {
                $dataQc = [
                    'case_id' => $caseId,
                    'kesimpulan' => $kesimpulanTestFly,
                ];

                $resultQc = $this->repairQc->createQc($dataQc);
            }

            foreach ($cekTestfly as $index => $item) {
                $listCheck = in_array($item, $checkboxTestfly) ? 1 : 0;
                $dataCekTestFly = [
                    'employee_id' => $employeeId,
                    'qc_id' => $resultQc->id,
                    'kategori_cek_id' => $item,
                    'check' => $listCheck,
                    'keterangan' => $keteranganTestfly[$index],
                ];

                $this->repairQc->createQcTestFly($dataCekTestFly);
            }

            $this->repairQc->commitTransaction();
            return ['status' => 'success', 'message' => 'Berhasil membuat quality control testfly baru.'];

        } catch (Exception $e) {
            $this->repairQc->rollbackTransaction();
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }
}