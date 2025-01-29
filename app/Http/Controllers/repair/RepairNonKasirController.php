<?php

namespace App\Http\Controllers\repair;

use Illuminate\Http\Request;
use App\Models\customer\Customer;
use App\Models\repair\RepairCase;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Services\repair\CustomerService;
use App\Repositories\umum\UmumRepository;
use App\Services\repair\RepairCaseService;

class RepairNonKasirController extends Controller
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

        return view('repair.csr.non-kasir', [
            'title' => 'Non Kasir',
            'active' => 'non-kasir',
            'navActive' => 'csr',
            'dropdown' => '',
            'divisi' => $divisiName,
            'dataCase' => $dataCase,
        ]);

    }

    public function downloadCustomers()
    {
        $cases = RepairCase::all();
        $csvData = $this->generateCsv($cases);
        $fileName = 'Case Repair.csv';
        Storage::disk('local')->put($fileName, $csvData);

        return response()->download(storage_path('app/' . $fileName))->deleteFileAfterSend(true);
    }

    private function generateCsv($cases)
    {
        $csv = "ID Case,ID Customer,Name,Phone,Jenis Produk\n";
        foreach ($cases as $case) {
            $csv .= "{$case->id},{$case->customer->id},{$case->customer->first_name} {$case->customer->last_name},{$case->customer->no_telpon},{$case->jenisProduk->jenis_produk}\n";
        }
        return $csv;
    }

}
