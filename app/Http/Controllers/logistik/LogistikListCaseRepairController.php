<?php

namespace App\Http\Controllers\logistik;

use App\Http\Controllers\Controller;
use App\Repositories\umum\UmumRepository;
use App\Services\repair\RepairCaseService;
use Illuminate\Http\Request;

class LogistikListCaseRepairController extends Controller
{
    public function __construct(
        private UmumRepository $umum,
        private RepairCaseService $caseService
    ){}

    public function index()
    {
        $user = auth()->user();
        $divisiName = $this->umum->getDivisi($user);
        $caseService = $this->caseService->getDataDropdown();
        $dataCase = $caseService['data_case'];

        return view('logistik.list-case.list-case-repair', [
            'title' => 'List Case Repair',
            'active' => 'list-case',
            'divisi' => $divisiName,
            'dataCase' => $dataCase,
        ]);
    }

    public function pageDetailListCaseLogistik($encryptId)
    {
        $user = auth()->user();
        $id = decrypt($encryptId);
        $divisiName = $this->umum->getDivisi($user);
        $dataCase = $this->caseService->findCase($id);

        return view('logistik.list-case.pages.detail-list-case-repair', [
            'title' => 'Detail List Case',
            'active' => 'list-case',
            'navActive' => 'csr',
            'dropdown' => '',
            'divisi' => $divisiName,
            'case' => $dataCase,
        ]);
    }
}
