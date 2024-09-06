<?php

namespace App\Http\Controllers\repair;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\umum\UmumRepository;
use App\Services\repair\RepairCaseService;
use App\Services\repair\RepairEstimasiService;

class RepairEstimasiBiayaController extends Controller
{
    protected $repairCaseService, $serviceEstimasi;
    public function __construct(private UmumRepository $nameDivisi, RepairCaseService $repairCaseService, RepairEstimasiService $repairEstimasiService)
    {
        $this->repairCaseService = $repairCaseService;
        $this->serviceEstimasi = $repairEstimasiService;
    }

    public function index()
    {
        $user = auth()->user();
        $caseService = $this->repairCaseService->getDataDropdown();
        $divisiName = $this->nameDivisi->getDivisi($user);
        $dataCase = $caseService['data_case'];

        return view('repair.estimasi.estimasi-biaya', [
            'title' => 'List Estimasi Biaya',
            'active' => 'estimasi-biaya',
            'navActive' => 'estimasi',
            'dropdown' => '',
            'divisi' => $divisiName,
            'dataCase' => $dataCase,
        ]);

    }

    public function edit($encryptId)
    {
        $id = decrypt($encryptId);
        $user = auth()->user();
        $jenisTransaksi = $this->serviceEstimasi->dataJenisTransaksi();
        $dataCase = $this->repairCaseService->findCase($id);
        $divisiName = $this->nameDivisi->getDivisi($user);

        return view('repair.estimasi.edit.form-estimasi-biaya', [
            'title' => 'List Estimasi Biaya',
            'active' => 'estimasi-biaya',
            'navActive' => 'estimasi',
            'divisi' => $divisiName,
            'dataCase' => $dataCase,
            'jenisTransaksi' => $jenisTransaksi,
        ]);

    }

    public function update(Request $request, $id)
    {
        $resultEstimasi = $this->serviceEstimasi->createEstimasi($request, $id);

        if ($resultEstimasi['status'] === 'success') {
            return redirect()->route('estimasi-biaya.index')->with('success', $resultEstimasi['message']);
        } else {
            return back()->with('error', $resultEstimasi['message']);
        }
    }

    public function inputJurnalEstimasi(Request $request)
    {
        $resultJurnal = $this->serviceEstimasi->addJurnalEstimasi($request);

        if ($resultJurnal['status'] === 'success') {
            return back()->with('success', $resultJurnal['message']);
        } else {
            return back()->with('error', $resultJurnal['message']);
        }
    }

    public function getJenisDrone($jenisTransaksi)
    {
        return $this->serviceEstimasi->getJenisDrone($jenisTransaksi);
    }

    public function getPartGudang($jenisTransaksi, $jenisDrone)
    {
        return $this->serviceEstimasi->getNamaPart($jenisTransaksi, $jenisDrone);
    }

    public function getDetailGudang($jenisTransaksi, $sku)
    {
        return $this->serviceEstimasi->getDetailPart($jenisTransaksi, $sku);
    }

}
