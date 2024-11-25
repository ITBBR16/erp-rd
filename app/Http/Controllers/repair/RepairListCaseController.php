<?php

namespace App\Http\Controllers\repair;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\umum\UmumRepository;
use App\Models\customer\CustomerInfoPerusahaan;
use App\Models\produk\ProdukJenis;
use App\Services\repair\CustomerService;
use App\Services\repair\RepairCaseService;
use Barryvdh\DomPDF\Facade\Pdf;

class RepairListCaseController extends Controller
{
    protected $customerService, $repairCaseService;
    public function __construct(private UmumRepository $nameDivisi, CustomerService $customerService, RepairCaseService $repairCaseService)
    {
        $this->customerService = $customerService;
        $this->repairCaseService = $repairCaseService;
    }

    public function index()
    {
        $user = auth()->user();
        $caseService = $this->repairCaseService->getDataDropdown();
        $divisiName = $this->nameDivisi->getDivisi($user);
        $dataCase = $caseService['data_case'];
        $dataCustomer = collect($caseService['data_customer'])->sortByDesc('id');
        $dataProvinsi = $caseService['data_provinsi'];
        $dataJenisCase = $caseService['jenis_case'];
        $dataJenisDrone = $caseService['jenis_drone'];
        $dataFungsionalDrone = $caseService['fungsional_drone'];
        $infoPerusahaan = CustomerInfoPerusahaan::all();

        return view('repair.csr.case-list', [
            'title' => 'Case List',
            'active' => 'list-case',
            'navActive' => 'csr',
            'dropdown' => '',
            'divisi' => $divisiName,
            'dataCase' => $dataCase,
            'dataCustomer' => $dataCustomer,
            'dataProvinsi' => $dataProvinsi,
            'infoPerusahaan' => $infoPerusahaan,
            'jenisCase' => $dataJenisCase,
            'jenisDrone' => $dataJenisDrone,
            'fungsionalDrone' => $dataFungsionalDrone,
        ]);

    }

    public function edit($encryptId)
    {
        $user = auth()->user();
        $id = decrypt($encryptId);
        $caseService = $this->repairCaseService->getDataDropdown();
        $divisiName = $this->nameDivisi->getDivisi($user);
        $dataCase = $this->repairCaseService->findCase($id);
        $dataProvinsi = $caseService['data_provinsi'];
        $dataJenisCase = $caseService['jenis_case'];
        $dataJenisDrone = $caseService['jenis_drone'];
        $dataFungsionalDrone = $caseService['fungsional_drone'];
        $infoPerusahaan = CustomerInfoPerusahaan::all();

        return view('repair.csr.edit.edit-list-case', [
            'title' => 'Edit Case List',
            'active' => 'list-case',
            'navActive' => 'csr',
            'divisi' => $divisiName,
            'dataCase' => $dataCase,
            'dataProvinsi' => $dataProvinsi,
            'infoPerusahaan' => $infoPerusahaan,
            'jenisCase' => $dataJenisCase,
            'jenisDrone' => $dataJenisDrone,
            'fungsionalDrone' => $dataFungsionalDrone,
        ]);
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
