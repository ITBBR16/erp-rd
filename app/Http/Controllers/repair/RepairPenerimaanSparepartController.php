<?php

namespace App\Http\Controllers\repair;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\umum\UmumRepository;
use App\Services\repair\RepairCaseService;

class RepairPenerimaanSparepartController extends Controller
{
    protected $repairCaseService;
    public function __construct(private UmumRepository $nameDivisi, RepairCaseService $repairCaseService)
    {
        $this->repairCaseService = $repairCaseService;
    }

    public function index()
    {
        $user = auth()->user();
        $divisiName = $this->nameDivisi->getDivisi($user);
        $caseService = $this->repairCaseService->getDataDropdown();
        $dataCase = $caseService['data_case'];

        return view('repair.csr.penerimaan-sparepart', [
            'title' => 'Penerimaan Sparepart',
            'active' => 'penerimaan-part',
            'navActive' => 'csr',
            'dropdown' => 'req-part',
            'divisi' => $divisiName,
            'dataCase' => $dataCase,
        ]);
    }
}
