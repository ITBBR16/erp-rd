<?php

namespace App\Services\repair;

use Exception;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Repositories\umum\UmumRepository;
use App\Repositories\repair\repository\RepairTeknisiRepository;
use App\Repositories\repair\repository\RepairTimeJurnalRepository;

class RepairTeknisiService
{
    public function __construct(
        private UmumRepository $umum,
        private RepairTeknisiRepository $repairTeknisi,
        private RepairCaseService $repairCaseService,
        private RepairTimeJurnalRepository $repairTimeJurnal)
    {}

    // Troubleshooting
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
            // Validasi Input
            $request->validate([
                'jurnal_troubleshooting' => 'required|string',
                'link_doc' => 'required|url',
                'files_troubleshooting.*' => 'file|mimes:jpg,jpeg,png,pdf|max:2048',
            ]);

            $tglWaktu = Carbon::now();
            $jurnalTS = $request->input('jurnal_troubleshooting');
            $linkDrive = $request->input('link_doc');
            $imgTS = $request->file('files_troubleshooting');

            if ($imgTS) {
                $encodedFiles = [];

                foreach ($imgTS as $file) {
                    $encodedFiles[] = base64_encode(file_get_contents($file->getPathname()));
                }

                $payload = [
                    'status' => 'Troubleshooting',
                    'link_drive' => $linkDrive,
                    'files' => $encodedFiles,
                ];
    
                $urlApi = 'https://script.google.com/macros/s/AKfycbygVDxzRgXbmbMBgCl3G5MZU7ZGMuMP9HO2xARk3_GQXI19JVflcUeQK6kLnXN31o6F/exec';
                $response = Http::post($urlApi, $payload);
    
                if ($response->failed()) {
                    throw new Exception('Gagal mengirim data ke Google Drive.');
                }
    
                $dataResponse = json_decode($response->body(), true);
                if ($dataResponse['status'] !== 'success') {
                    throw new Exception($dataResponse['message'] ?? 'Terjadi kesalahan pada API.');
                }
            }

            $checkTimestamp = $this->repairTimeJurnal->findTimestime($id, 2);
            $timestamp = $checkTimestamp ?? $this->repairTimeJurnal->createTimestamp([
                'case_id' => $id,
                'jenis_status_id' => 2,
                'tanggal_waktu' => $tglWaktu,
            ]);

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

    // Pengerjaan
    public function indexPengerjaan()
    {
        $user = auth()->user();
        $caseService = $this->repairCaseService->getDataDropdown();
        $divisiName = $this->umum->getDivisi($user);
        $dataCase = $caseService['data_case']->sortByDesc('created_at');

        return view('repair.teknisi.pengerjaan', [
            'title' => 'List Pengerjaan',
            'active' => 'pengerjaan',
            'navActive' => 'teknisi',
            'dropdown' => '',
            'divisi' => $divisiName,
            'dataCase' => $dataCase,
        ]);
    }

    public function pageDetailPengerjaan($encryptId)
    {
        $user = auth()->user();
        $id = decrypt($encryptId);
        $divisiName = $this->umum->getDivisi($user);
        $dataCase = $this->repairCaseService->findCase($id);

        return view('repair.teknisi.pages.detail-case-pengerjaan', [
            'title' => 'Detail List Pengerjaan',
            'active' => 'pengerjaan',
            'navActive' => 'teknisi',
            'dropdown' => '',
            'divisi' => $divisiName,
            'case' => $dataCase,
        ]);
    }

    public function createJurnalPengerjaan(Request $request, $id)
    {
        $this->repairTeknisi->beginTransaction();
        $employeeId = auth()->user()->id;

        try {
            $tglWaktu = Carbon::now();
            $jurnalTS = $request->input('jurnal_pengerjaan');
            $linkDrive = $request->input('link_doc');
            $imgPengerjaan = $request->file('files_pengerjaan');
            
            if ($imgPengerjaan) {
                $encodedFiles = [];
                foreach ($imgPengerjaan as $file) {
                    $encodedFiles[] = base64_encode($file->get());
                }
    
                $payload = [
                    'status' => 'Pengerjaan',
                    'link_drive' => $linkDrive,
                    'files' => $encodedFiles,
                ];
    
                $urlApi = 'https://script.google.com/macros/s/AKfycbygVDxzRgXbmbMBgCl3G5MZU7ZGMuMP9HO2xARk3_GQXI19JVflcUeQK6kLnXN31o6F/exec';
                $response = Http::post($urlApi, $payload);
                $dataResponse = json_decode($response->body(), true);
                $status = $dataResponse['status'];

            }

            $checkTimestamp = $this->repairTimeJurnal->findTimestime($id, 6);
            if ($checkTimestamp) {
                $timestamp = $checkTimestamp;
            } else {
                $dataTimestamp = [
                    'case_id' => $id,
                    'jenis_status_id' => 6,
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

    public function changeStatusPengerjaan($id)
    {
        $this->repairTeknisi->beginTransaction();
        $employeeId = auth()->user()->id;

        try {
            $tglWaktu = Carbon::now();

            $dataTimestamp = [
                'case_id' => $id,
                'jenis_status_id' => 7,
                'tanggal_waktu' => $tglWaktu,
            ];
            $timestamp = $this->repairTimeJurnal->createTimestamp($dataTimestamp);

            $dataJurnal = [
                'employee_id' => $employeeId,
                'jenis_substatus_id' => 1,
                'timestamps_status_id' => $timestamp->id,
                'isi_jurnal' => 'Ganti status to Quality Control',
            ];

            $this->repairTimeJurnal->addJurnal($dataJurnal);

            $dataUpdate = [
                'jenis_status_id' => 7,
            ];

            $this->repairTeknisi->updateStatusCase($id, $dataUpdate);

            $this->repairTeknisi->commitTransaction();
            return ['status' => 'success', 'message' => 'Berhasil lanjut ke quality control.'];

        } catch (Exception $e) {
            $this->repairTeknisi->rollBackTransaction();
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    // Request Sparepart
    public function createReqPartTeknisi(Request $request, $id)
    {
        $this->repairTeknisi->beginTransaction();

        try {
            $tglRequest = Carbon::now();
            $statusCaseId = $request->input('status_case_id');
            $jenisProduk = $request->input('jenis_produk');
            $namaPart = $request->input('nama_part');
            $skuPart = $request->input('sku_part');
            $qtyReq = $request->input('qty_req');

            foreach ($jenisProduk as $index => $produk) {
                $qtyItem = $qtyReq[$index];
                for ($i = 0; $i < $qtyItem; $i++) {
                    $dataSend = [
                        'case_id' => $id,
                        'sku' => $skuPart[$index],
                        'jenis_produk' => $produk,
                        'nama_produk' => $namaPart[$index],
                        'status_proses_id' => $statusCaseId,
                        'tanggal_request' => $tglRequest,
                        'status' => 'Request',
                    ];

                    $this->repairTeknisi->createRequestPart($dataSend);
                }
            }

            $this->repairTeknisi->commitTransaction();
            return ['status' => 'success', 'message' => 'Berhasil melakukan request sparepart.'];

        } catch (Exception $e) {
            $this->repairTeknisi->rollBackTransaction();
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }
}