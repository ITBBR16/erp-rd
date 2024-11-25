<?php

namespace App\Http\Controllers\repair;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\umum\UmumRepository;
use App\Services\repair\RepairCaseService;
use App\Services\repair\RepairTeknisiService;

class RepairTeknisiRequestSparepartController extends Controller
{
    protected $caseService, $teknisiService;
    public function __construct(private UmumRepository $nameDivisi, RepairCaseService $repairCaseService, RepairTeknisiService $repairTeknisiService)
    {
        $this->caseService = $repairCaseService;
        $this->teknisiService = $repairTeknisiService;
    }

    public function index()
    {
        $user = auth()->user();
        $divisiName = $this->nameDivisi->getDivisi($user);
        $caseService = $this->caseService->getDataDropdown();
        $dataCase = $caseService['data_case'];

        return view('repair.teknisi.ddpart.req-sparepart', [
            'title' => 'Request Sparepart',
            'active' => 'req-part',
            'navActive' => 'teknisi',
            'dropdown' => 'req-part',
            'divisi' => $divisiName,
            'dataCase' => $dataCase,
        ]);

    }

    public function update(Request $request, $id)
    {
        $resultReqSparepart = $this->teknisiService->createReqPartTeknisi($request, $id);
        return back()->with($resultReqSparepart['status'], $resultReqSparepart['message']);
    }
}
