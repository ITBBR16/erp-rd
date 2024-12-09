<?php

namespace App\Http\Controllers\repair;

use App\Http\Controllers\Controller;
use App\Services\repair\RepairCaseService;
use Barryvdh\DomPDF\Facade\Pdf;

class RepairKonfirmasiQCController extends Controller
{
    public function __construct(
        private RepairCaseService $caseService)
    {}

    public function index()
    {
        return $this->caseService->indexKonfirmasiQC();
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
