<?php

namespace App\Http\Controllers\repair;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\umum\UmumRepository;
use App\Services\repair\RepairCaseService;

class RepairEstimasiBiayaController extends Controller
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

        return view('repair.estimasi.estimasi-biaya', [
            'title' => 'List Estimasi Biaya',
            'active' => 'estimasi-biaya',
            'navActive' => 'estimasi',
            'divisi' => $divisiName,
            'dataCase' => $dataCase,
        ]);

    }

    public function edit($encryptId)
    {
        $id = decrypt($encryptId);
        $user = auth()->user();
        $dataCase = $this->repairCaseService->findCase($id);
        $divisiName = $this->nameDivisi->getDivisi($user);

        return view('repair.estimasi.edit.form-estimasi-biaya', [
            'title' => 'List Estimasi Biaya',
            'active' => 'estimasi-biaya',
            'navActive' => 'estimasi',
            'divisi' => $divisiName,
            'dataCase' => $dataCase,
        ]);

    }

}
