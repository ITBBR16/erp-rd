<?php

namespace App\Http\Controllers\repair;

use App\Http\Controllers\Controller;
use App\Services\repair\CustomerService;
use App\Repositories\umum\UmumRepository;
use App\Services\repair\RepairCaseService;

class RepairTeknisiLCController extends Controller
{
    public function __construct(
        private UmumRepository $umum,
        private CustomerService $customerService,
        private RepairCaseService $repairCaseService
    ){}

    public function index()
    {
        $user = auth()->user();
        $caseService = $this->repairCaseService->getDataDropdown();
        $divisiName = $this->umum->getDivisi($user);
        $dataCase = $caseService['data_case']->sortByDesc('created_at');

        return view('repair.teknisi.case-list', [
            'title' => 'Case List',
            'active' => 'list-case',
            'navActive' => 'teknisi',
            'dropdown' => '',
            'divisi' => $divisiName,
            'dataCase' => $dataCase,
        ]);

    }

    public function pageDetailCaseTeknisi($encryptId)
    {
        $user = auth()->user();
        $id = decrypt($encryptId);
        $divisiName = $this->umum->getDivisi($user);
        $dataCase = $this->repairCaseService->findCase($id);

        return view('repair.teknisi.pages.detail-case-teknisi', [
            'title' => 'Detail List Case',
            'active' => 'list-case',
            'navActive' => 'teknisi',
            'dropdown' => '',
            'divisi' => $divisiName,
            'case' => $dataCase,
        ]);
    }

}
