<?php

namespace App\Http\Controllers\repair;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\umum\UmumRepository;
use App\Services\repair\RepairCaseService;
use App\Repositories\repair\repository\RepairCustomerRepository;

class KasirRepairController extends Controller
{
    protected $caseService;
    public function __construct(private UmumRepository $nameDivisi, private RepairCustomerRepository $repairCustomer, RepairCaseService $repairCaseService)
    {
        $this->caseService = $repairCaseService;
    }

    public function index()
    {
        $user = auth()->user();
        $divisiName = $this->nameDivisi->getDivisi($user);
        $dataProvinsi = $this->repairCustomer->getProvinsi();
        $caseService = $this->caseService->getDataDropdown();
        $dataCase = $caseService['data_case'];

        return view('repair.csr.kasir-repair', [
            'title' => 'Kasir Repair',
            'active' => 'kasir-repair',
            'navActive' => 'csr',
            'dropdown' => '',
            'divisi' => $divisiName,
            'dataProvinsi' => $dataProvinsi,
            'dataCase' => $dataCase,
        ]);

    }

    public function edit($id)
    {
        $user = auth()->user();
        $divisiName = $this->nameDivisi->getDivisi($user);
        $dataCase = $this->caseService->findCase($id);

        return view('repair.csr.edit.kasir-pelunasan', [
            'title' => 'Kasir Repair',
            'active' => 'kasir-repair',
            'navActive' => 'csr',
            'divisi' => $divisiName,
            'dataCase' => $dataCase,
        ]);
    }

}
