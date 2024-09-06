<?php

namespace App\Http\Controllers\repair;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\umum\UmumRepository;
use App\Services\repair\RepairCaseService;
use App\Services\repair\RepairQCService;

class RepairQCController extends Controller
{
    protected $caseService, $qcService;
    public function __construct(private UmumRepository $nameDivisi, RepairCaseService $repairCaseService, RepairQCService $repairQCService)
    {
        $this->caseService = $repairCaseService;
        $this->qcService = $repairQCService;
    }

    public function index()
    {
        $user = auth()->user();
        $caseService = $this->caseService->getDataDropdown();
        $divisiName = $this->nameDivisi->getDivisi($user);
        $dataQc = $this->qcService->getDataNeed();
        $kondisi = $dataQc['kondisi'];
        $kategori = $dataQc['kategori'];
        $dataCase = $caseService['data_case'];

        return view('repair.qc.quality-control', [
            'title' => 'Pengecekkan',
            'active' => 'pengecekkan',
            'navActive' => 'qc',
            'dropdown' => '',
            'divisi' => $divisiName,
            'dataCase' => $dataCase,
            'kategoris' => $kategori,
            'kondisis' => $kondisi,
        ]);

    }

    public function update(Request $request, $id)
    {
        $resultChangeStatu = $this->qcService->changeStatus($request, $id);

        if ($resultChangeStatu['status'] == 'success') {
            return back()->with('success', $resultChangeStatu['message']);
        } else {
            return back()->with('error', $resultChangeStatu['message']);
        }
    }

    public function createQcFisik(Request $request)
    {
        $resutlFisik = $this->qcService->createQcFisik($request);

        if ($resutlFisik['status'] == 'success') {
            return back()->with('success', $resutlFisik['message']);
        } else {
            return back()->with('error', $resutlFisik['message']);
        }
    }

    public function createQcCalibrasi(Request $request)
    {
        $resutlCalibrasi = $this->qcService->createCalibrasi($request);

        if ($resutlCalibrasi['status'] == 'success') {
            return back()->with('success', $resutlCalibrasi['message']);
        } else {
            return back()->with('error', $resutlCalibrasi['message']);
        }
    }

    public function createTestFly(Request $request)
    {
        $resutlTestfly = $this->qcService->createTestFly($request);

        if ($resutlTestfly['status'] == 'success') {
            return back()->with('success', $resutlTestfly['message']);
        } else {
            return back()->with('error', $resutlTestfly['message']);
        }
    }
}
