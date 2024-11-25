<?php

namespace App\Http\Controllers\repair;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\repair\CustomerService;
use App\Repositories\umum\UmumRepository;
use App\Services\repair\RepairCaseService;
use App\Services\repair\RepairTeknisiService;

class RepairTeknisiNCController extends Controller
{
    protected $repairCaseService, $repairTeknisi;
    public function __construct(private UmumRepository $nameDivisi, RepairTeknisiService $repairTeknisiService, RepairCaseService $repairCaseService)
    {
        $this->repairTeknisi = $repairTeknisiService;
        $this->repairCaseService = $repairCaseService;
    }

    public function index()
    {
        $user = auth()->user();
        $caseService = $this->repairCaseService->getDataDropdown();
        $divisiName = $this->nameDivisi->getDivisi($user);
        $dataCase = $caseService['data_case'];

        return view('repair.teknisi.new-case-teknisi', [
            'title' => 'New Case List',
            'active' => 'new-case',
            'navActive' => 'teknisi',
            'dropdown' => '',
            'divisi' => $divisiName,
            'dataCase' => $dataCase,
        ]);

    }

    public function update($id)
    {
        $resultAmbilCase = $this->repairTeknisi->ambilCase($id);
        return back()->with($resultAmbilCase['status'], $resultAmbilCase['message']);
    }

}
