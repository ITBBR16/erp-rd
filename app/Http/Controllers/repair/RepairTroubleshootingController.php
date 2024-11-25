<?php

namespace App\Http\Controllers\repair;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\umum\UmumRepository;
use App\Services\repair\RepairCaseService;
use App\Services\repair\RepairTeknisiService;

class RepairTroubleshootingController extends Controller
{
    protected $repairCaseService, $repairTeknisi;
    public function __construct(private UmumRepository $nameDivisi, RepairCaseService $repairCaseService, RepairTeknisiService $repairTeknisiService)
    {
        $this->repairCaseService = $repairCaseService;
        $this->repairTeknisi = $repairTeknisiService;
    }

    public function index()
    {
        $user = auth()->user();
        $caseService = $this->repairCaseService->getDataDropdown();
        $divisiName = $this->nameDivisi->getDivisi($user);
        $dataCase = $caseService['data_case'];

        return view('repair.teknisi.troubleshooting', [
            'title' => 'List Troubleshooting',
            'active' => 'troubleshooting',
            'navActive' => 'teknisi',
            'dropdown' => '',
            'divisi' => $divisiName,
            'dataCase' => $dataCase,
        ]);

    }

    public function update(Request $request, $id)
    {
        $resultJurnal = $this->repairTeknisi->createJurnal($request, $id);
        return back()->with($resultJurnal['status'], $resultJurnal['message']);
    }

    public function changeStatus($id)
    {
        $resultJurnal = $this->repairTeknisi->changeStatus($id);
        return back()->with($resultJurnal['status'], $resultJurnal['message']);
    }

}
