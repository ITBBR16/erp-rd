<?php

namespace App\Http\Controllers\repair;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\umum\UmumRepository;
use App\Services\repair\RepairCaseService;
use Barryvdh\DomPDF\Facade\Pdf;

class RepairKonfirmasiQCController extends Controller
{
    protected $caseService;
    public function __construct(private UmumRepository $nameDivisi, RepairCaseService $repairCaseService)
    {
        $this->caseService = $repairCaseService;
    }

    public function index()
    {
        $user = auth()->user();
        $divisiName = $this->nameDivisi->getDivisi($user);
        $caseService = $this->caseService->getDataDropdown();
        $dataCase = $caseService['data_case'];

        return view('repair.csr.konfirmasi-qc', [
            'title' => 'Konfirmasi QC',
            'active' => 'konf-qc',
            'navActive' => 'csr',
            'dropdown' => '',
            'divisi' => $divisiName,
            'dataCase' => $dataCase,
        ]);

    }

    public function update($id)
    {
        $resultKonfQC = $this->caseService->konfirmasiQc($id);
        return back()->with($resultKonfQC['status'], $resultKonfQC['message']);
    }

    public function sendKonfirmasiQC($id)
    {
        $resultSend = $this->caseService->sendKonfirmasiQC($id);
        return back()->with($resultSend['status'], $resultSend['message']);
    }

    public function previewPdfQc($id)
    {
        $dataCase = $this->caseService->findCase($id);
        $data = [
            'title' => 'Preview QC',
            'case' => $dataCase,
        ];

        $pdf = Pdf::loadView('repair.csr.preview.preview-qc', $data);
        return $pdf->stream();
        // return $pdf->download('aww.pdf');
    }

}
