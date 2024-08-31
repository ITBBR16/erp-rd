<?php

namespace App\Http\Controllers\repair;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\umum\UmumRepository;
use App\Services\repair\RepairCaseService;
use App\Services\repair\RepairTeknisiService;

class RepairPengerjaanController extends Controller
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

        return view('repair.teknisi.pengerjaan', [
            'title' => 'List Pengerjaan',
            'active' => 'pengerjaan',
            'navActive' => 'teknisi',
            'divisi' => $divisiName,
            'dataCase' => $dataCase,
        ]);

    }

    public function update(Request $request, $id)
    {
        $resultJurnal = $this->repairTeknisi->createJurnalPengerjaan($request, $id);

        if ($resultJurnal['status'] == 'success') {
            return back()->with('success', $resultJurnal['message']);
        } else {
            return back()->with('error', $resultJurnal['message']);
        }
    }

    public function changeStatusPengerjaan($id)
    {
        $resultStatus = $this->repairTeknisi->changeStatusPengerjaan($id);

        if ($resultStatus['status'] == 'success') {
            return back()->with('success', $resultStatus['message']);
        } else {
            return back()->with('error', $resultStatus['message']);
        }
    }
}
