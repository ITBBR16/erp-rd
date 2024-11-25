<?php

namespace App\Http\Controllers\repair;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\umum\UmumRepository;
use App\Services\repair\RepairCaseService;
use App\Services\repair\RepairEstimasiService;

class RepairRequestSparepartController extends Controller
{
    protected $caseService, $estimasiService;
    public function __construct(private UmumRepository $nameDivisi, RepairCaseService $repairCaseService, RepairEstimasiService $repairEstimasiService)
    {
        $this->caseService = $repairCaseService;
        $this->estimasiService = $repairEstimasiService;
    }

    public function index()
    {
        $user = auth()->user();
        $divisiName = $this->nameDivisi->getDivisi($user);
        $caseService = $this->caseService->getDataDropdown();
        $dataCase = $caseService['data_case'];

        return view('repair.csr.req-sparepart', [
            'title' => 'Request Sparepart',
            'active' => 'req-part',
            'navActive' => 'csr',
            'dropdown' => 'req-part',
            'divisi' => $divisiName,
            'dataCase' => $dataCase,
        ]);

    }

    public function update(Request $request, $id)
    {
        $resultReqSparepart = $this->estimasiService->requestPartEstimasi($request, $id);
        return back()->with($resultReqSparepart['status'], $resultReqSparepart['message']);
    }
}
