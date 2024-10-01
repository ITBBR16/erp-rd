<?php

namespace App\Http\Controllers\repair;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\repair\CustomerService;
use App\Repositories\umum\UmumRepository;
use App\Services\repair\RepairCaseService;

class RepairNonKasirController extends Controller
{
    protected $customerService, $repairCaseService;
    public function __construct(private UmumRepository $nameDivisi, CustomerService $customerService, RepairCaseService $repairCaseService)
    {
        $this->customerService = $customerService;
        $this->repairCaseService = $repairCaseService;
    }

    public function index()
    {
        $user = auth()->user();
        $caseService = $this->repairCaseService->getDataDropdown();
        $divisiName = $this->nameDivisi->getDivisi($user);
        $dataCase = $caseService['data_case'];

        return view('repair.csr.non-kasir', [
            'title' => 'Non Kasir',
            'active' => 'non-kasir',
            'navActive' => 'csr',
            'dropdown' => '',
            'divisi' => $divisiName,
            'dataCase' => $dataCase,
        ]);

    }

}
