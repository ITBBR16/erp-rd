<?php

namespace App\Http\Controllers\repair;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\produk\ProdukJenis;
use App\Services\repair\CustomerService;
use App\Services\repair\RepairCaseService;

class RepairListCaseController extends Controller
{
    public function __construct(
        private CustomerService $customerService,
        private RepairCaseService $repairCaseService
    ){}

    public function index()
    {
        return $this->repairCaseService->indexNewCase();
    }

    public function edit($encryptId)
    {
        return $this->repairCaseService->editNewCase($encryptId);
    }

    public function update(Request $request, $id)
    {
        $resultUpdate = $this->repairCaseService->updateCase($request, $id);
        
        if ($resultUpdate['status'] === 'success') {
            return redirect()->route('case-list.index')->with($resultUpdate['status'], $resultUpdate['message']);
        } else {
            return back()->with($resultUpdate['status'], $resultUpdate['message']);
        }
    }

    public function detailListCase($encryptId)
    {
        return $this->repairCaseService->pageDetailListCase($encryptId);
    }

    public function createNC(Request $request)
    {
        $result = $this->customerService->createNewCustomer($request);
        return back()->with($result['status'], $result['message']);
    }

    public function store(Request $request)
    {
        $resultCase = $this->repairCaseService->createNewCase($request);
        return back()->with($resultCase['status'], $resultCase['message']);
    }

    public function reviewPdfInvoiceLunas($encryptId)
    {
        $id = decrypt($encryptId);
        $pdf = $this->repairCaseService->reviewPdfLunas($id);
        return $pdf->stream();
    }

    public function reviewPdfTandaTerima($id)
    {
        $pdf = $this->repairCaseService->reviewPdfTandaTerima($id);
        return $pdf->stream();
    }

    public function downloadPdf($id)
    {
        $pdf = $this->repairCaseService->downloadPdfTandaTerima($id);
        return $pdf['pdf']->download($pdf['namaCustomer'] . ".pdf");
    }

    public function kirimTandaTerimaCustomer($id)
    {
        $resultTandaTerima = $this->repairCaseService->kirimTandaTerimaCustomer($id);
        return back()->with($resultTandaTerima['status'], $resultTandaTerima['message']);
    }

    public function getKelengkapan($id)
    {
        $productSearch = ProdukJenis::findOrFail($id);
        $dataKelengkapan = $productSearch->kelengkapans()->get();

        return response()->json($dataKelengkapan);
    }

}
