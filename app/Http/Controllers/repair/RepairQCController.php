<?php

namespace App\Http\Controllers\repair;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\repair\RepairCaseService;
use App\Services\repair\RepairQCService;

class RepairQCController extends Controller
{
    public function __construct(
        private RepairCaseService $caseService,
        private RepairQCService $qcService)
    {}

    public function indexListCase()
    {
        return $this->qcService->indexListCase();
    }

    public function index()
    {
        return $this->qcService->indexQc();
    }

    public function detailQualityControl($encryptId)
    {
        return $this->qcService->detailQc($encryptId);
    }

    public function update(Request $request, $id)
    {
        $resultChangeStatu = $this->qcService->changeStatus($request, $id);
        return back()->with($resultChangeStatu['status'], $resultChangeStatu['message']);
    }

    public function createJurnalQc(Request $request)
    {
        $resultJurnal = $this->qcService->addJurnalQc($request);
        return back()->with($resultJurnal['status'], $resultJurnal['message']);
    }

    public function createQcFisik(Request $request)
    {
        $resutlFisik = $this->qcService->createQcFisik($request);
        return back()->with($resutlFisik['status'], $resutlFisik['message']);
    }

    public function createQcCalibrasi(Request $request)
    {
        $resutlCalibrasi = $this->qcService->createCalibrasi($request);
        return back()->with($resutlCalibrasi['status'], $resutlCalibrasi['message']);
    }

    public function createTestFly(Request $request)
    {
        $resutlTestfly = $this->qcService->createTestFly($request);
        return back()->with($resutlTestfly['status'], $resutlTestfly['message']);
    }
}
