<?php

namespace App\Http\Controllers\repair;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\umum\UmumRepository;
use App\Services\repair\RepairCaseService;
use App\Services\repair\RepairEstimasiService;

class RepairPenerimaanPartEstimasiController extends Controller
{
    public function __construct(
        private UmumRepository $umum,
        private RepairCaseService $repairCaseService, 
        private RepairEstimasiService $serviceEstimasi)
    {}

    public function index()
    {
        return $this->serviceEstimasi->indexPenerimaanPart();
    }

    public function store(Request $request)
    {
        $resultPenerimaan = $this->serviceEstimasi->penerimaanSparepartEstimasi($request);
        return back()->with($resultPenerimaan['status'], $resultPenerimaan['message']);
    }

    public function update(Request $request, $id)
    {
        $resultReqPart = $this->serviceEstimasi->requestPartEstimasi($request, $id);
        return back()->with($resultReqPart['status'], $resultReqPart['message']);
    }
}
