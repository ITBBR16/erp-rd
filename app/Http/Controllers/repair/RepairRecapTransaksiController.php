<?php

namespace App\Http\Controllers\repair;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\repair\CustomerService;
use App\Repositories\umum\UmumRepository;
use App\Services\management\AkuntanTransaksiService;
use App\Services\repair\RepairCaseService;

class RepairRecapTransaksiController extends Controller
{
    protected $customerService, $repairCaseService, $serviceAT;
    public function __construct(private UmumRepository $nameDivisi, CustomerService $customerService, RepairCaseService $repairCaseService, AkuntanTransaksiService $akuntanTransaksiService)
    {
        $this->customerService = $customerService;
        $this->repairCaseService = $repairCaseService;
        $this->serviceAT = $akuntanTransaksiService;
    }

    public function index()
    {
        $user = auth()->user();
        $caseService = $this->repairCaseService->getDataDropdown();
        $divisiName = $this->nameDivisi->getDivisi($user);
        $dataCase = $caseService['data_case'];
        $daftarAkun = $this->serviceAT->getAkunKasir();
        $mutasiToday = $this->serviceAT->getMutasiSementara();
        $dataMutasi = $this->serviceAT->getMutasi();
        $dataTransksaksi = $this->serviceAT->getDataTransaksi();

        return view('repair.csr.recap-transaksi', [
            'title' => 'Recap Transaksi',
            'active' => 'recap-transaksi',
            'navActive' => 'csr',
            'dropdown' => '',
            'divisi' => $divisiName,
            'dataCase' => $dataCase,
            'daftarAkun' => $daftarAkun,
            'dataMutasi' => $dataMutasi,
            'dataMutasiSementara' => $mutasiToday,
            'dataTransaksi' => $dataTransksaksi,
        ]);

    }

    public function store(Request $request)
    {
        $resultMS = $this->serviceAT->createMutasiSementara($request);

        if ($resultMS['status'] == 'success') {
            return back()->with('success', $resultMS['message']);
        } else {
            return back()->with('error', $resultMS['message']);
        }
    }

    public function pencocokanMutasiTransaksi(Request $request)
    {
        $resultMerge = $this->serviceAT->createPencocokan($request);

        if ($resultMerge['status'] == 'success') {
            return back()->with('success', $resultMerge['message']);
        } else {
            return back()->with('error', $resultMerge['message']);
        }
    }

    public function getSaldoAkhirMutasi($akunId)
    {
        return $this->serviceAT->getSaldoAkhirAkun($akunId);
    }

    public function findMutasiSementara($id)
    {
        return $this->serviceAT->findMutasiSementara($id);
    }

    public function findTransaksi($source, $id)
    {
        return $this->serviceAT->findTransaksi($source, $id);
    }

}
