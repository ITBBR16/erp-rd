<?php

namespace App\Http\Controllers\repair;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\umum\UmumRepository;
use App\Services\repair\RepairCaseService;
use App\Services\repair\RepairEstimasiService;

class RepairEstimasiReqSparepartController extends Controller
{
    public function __construct(
        private UmumRepository $umum,
        private RepairCaseService $serviceCase,
        private RepairEstimasiService $serviceEstimasi
    ){}

    public function index()
    {
        $user = auth()->user();
        $divisiName = $this->umum->getDivisi($user);
        $caseService = $this->serviceCase->getDataDropdown();
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
        return back()->with($resultReqPart['status'], $resultReqPart['message']);
    }
}
