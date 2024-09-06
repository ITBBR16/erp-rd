<?php

namespace App\Http\Controllers\repair;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\umum\UmumRepository;
use App\Services\repair\RepairCaseService;

class RepairRequestSparepartController extends Controller
{
    protected $caseService;
    public function __construct(private UmumRepository $nameDivisi, RepairCaseService $repairCaseService)
    {
        $this->caseService = $repairCaseService;
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
        $resultReqSparepart = $this->caseService->createReqSparepart($request, $id);

        if ($resultReqSparepart['status'] == 'success') {
            return back()->with('success', $resultReqSparepart['message']);
        } else {
            return back()->with('error', $resultReqSparepart['message']);
        }
    }
}
