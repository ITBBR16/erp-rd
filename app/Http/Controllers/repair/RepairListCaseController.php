<?php

namespace App\Http\Controllers\repair;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\umum\UmumRepository;
use App\Models\customer\CustomerInfoPerusahaan;
use App\Models\produk\ProdukJenis;
use App\Services\repair\CustomerService;
use App\Services\repair\RepairCaseService;

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
        $dataCustomer = $caseService['data_customer'];
        $dataProvinsi = $caseService['data_provinsi'];
        $dataJenisCase = $caseService['jenis_case'];
        $dataJenisDrone = $caseService['jenis_drone'];
        $dataFungsionalDrone = $caseService['fungsional_drone'];
        $infoPerusahaan = CustomerInfoPerusahaan::all();

        return view('repair.csr.case-list', [
            'title' => 'Case List',
            'active' => 'list-case',
            'navActive' => 'csr',
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

    public function edit()
    {
        $user = auth()->user();
        $divisiName = $this->nameDivisi->getDivisi($user);

        return view('repair.csr.invoice.invoice-penerimaan', [
            'title' => 'Case List',
            'active' => 'list-case',
            'navActive' => 'csr',
            'divisi' => $divisiName,
        ]);
    }

    public function createNC(Request $request)
    {
        $result = $this->customerService->createNewCustomer($request);

        if ($result['status'] === 'success') {
            return back()->with('success', $result['message']);
        } else {
            return back()->with('error', $result['message']);
        }
    }

    public function store(Request $request)
    {
        $resultCase = $this->repairCaseService->createNewCase($request);

        if ($resultCase['status'] === 'success') {
            return back()->with('success', $resultCase['message']);
        } else {
            return back()->with('error', $resultCase['message']);
        }
    }

    public function getKelengkapan($id)
    {
        $productSearch = ProdukJenis::findOrFail($id);
        $dataKelengkapan = $productSearch->kelengkapans()->get();

        return response()->json($dataKelengkapan);
    }

}
