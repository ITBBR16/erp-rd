<?php

namespace App\Http\Controllers\repair;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\umum\UmumRepository;
use App\Services\repair\RepairCaseService;
use App\Services\repair\RepairEstimasiService;

class RepairKonfirmasiReqPartController extends Controller
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
        $dataCase = $this->repairCaseService->getDataRequest();

        return view('repair.estimasi.konfirmasi-req-part', [
            'title' => 'List Konfirmasi Estimasi',
            'active' => 'konfirmasi-part',
            'navActive' => 'estimasi',
            'dropdown' => 'req-part',
            'divisi' => $divisiName,
            'dataCase' => $dataCase,
        ]);

    }

    public function store(Request $request)
    {
        $resultKonfReqPart = $this->serviceEstimasi->konfirmasiReqPart($request);
        return back()->with($resultKonfReqPart['status'], $resultKonfReqPart['message']);
    }

    public function getListPart($id)
    {
        return $this->serviceEstimasi->getListReqPart($id);
    }
}
