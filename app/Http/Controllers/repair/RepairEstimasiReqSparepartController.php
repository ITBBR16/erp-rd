<?php

namespace App\Http\Controllers\repair;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\umum\UmumRepository;
use App\Services\repair\RepairCaseService;
use App\Services\repair\RepairEstimasiService;

class RepairEstimasiReqSparepartController extends Controller
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
        $divisiName = $this->nameDivisi->getDivisi($user);
        $caseService = $this->repairCaseService->getDataDropdown();
        $dataCase = $caseService['data_case'];

        return view('repair.estimasi.req-sparepart', [
            'title' => 'Request Sparepart Estimasi',
            'active' => 'req-part-estimasi',
            'navActive' => 'estimasi',
            'dropdown' => 'req-part',
            'divisi' => $divisiName,
            'dataCase' => $dataCase,
        ]);

    }

    public function update(Request $request, $id)
    {
        $resultReqPart = $this->serviceEstimasi->requestPartEstimasi($request, $id);

        if ($resultReqPart['status'] == 'success') {
            return back()->with('success', $resultReqPart['message']);
        } else {
            return back()->with('error', $resultReqPart['message']);
        }
    }
}
