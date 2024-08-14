<?php

namespace App\Http\Controllers\repair;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\umum\UmumRepository;
use App\Services\repair\RepairCaseService;
use App\Services\repair\RepairTeknisiService;

class RepairTroubleshootingController extends Controller
{
    protected $repairCaseService;
    public function __construct(private UmumRepository $nameDivisi, RepairCaseService $repairCaseService)
    {
        $this->repairCaseService = $repairCaseService;
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
            'divisi' => $divisiName,
            'dataCase' => $dataCase,
        ]);

    }

}
