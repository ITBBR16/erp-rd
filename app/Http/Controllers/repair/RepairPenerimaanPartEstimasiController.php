<?php

namespace App\Http\Controllers\repair;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\umum\UmumRepository;
use App\Services\repair\RepairCaseService;
use App\Services\repair\RepairEstimasiService;

class RepairPenerimaanPartEstimasiController extends Controller
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
        $dataCase = $this->repairCaseService->getDataForPenerimaanPart();

        return view('repair.estimasi.penerimaan-sparepart', [
            'title' => 'Penerimaan Sparepart Estimasi',
            'active' => 'penerimaan-part-estimasi',
            'navActive' => 'estimasi',
            'dropdown' => 'req-part',
            'divisi' => $divisiName,
            'dataCase' => $dataCase,
        ]);

    }

    public function store(Request $request)
    {
        $resultPenerimaan = $this->serviceEstimasi->penerimaanSparepartEstimasi($request);

        if ($resultPenerimaan['status'] == 'success') {
            return back()->with('success', $resultPenerimaan['message']);
        } else {
            return back()->with('error', $resultPenerimaan['message']);
        }
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
