<?php

namespace App\Http\Controllers\repair;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\umum\UmumRepository;
use App\Services\repair\RepairCaseService;
use App\Services\repair\RepairEstimasiService;

class RepairKonfirmasiEstimasiController extends Controller
{
    protected $repairCaseService, $serviceEstimasi;
    public function __construct(private UmumRepository $nameDivisi, RepairCaseService $repairCaseService, RepairEstimasiService $repairEstimasiService)
    {
        $this->repairCaseService = $repairCaseService;
        $this->serviceEstimasi = $repairEstimasiService;
    }

    public function index()
    {
        $user = auth()->user();
        $caseService = $this->repairCaseService->getDataDropdown();
        $divisiName = $this->nameDivisi->getDivisi($user);
        $dataCase = $caseService['data_case'];

        return view('repair.estimasi.konfirmasi-estimasi', [
            'title' => 'List Konfirmasi Estimasi',
            'active' => 'konfirmasi-estimasi',
            'navActive' => 'estimasi',
            'divisi' => $divisiName,
            'dataCase' => $dataCase,
        ]);

    }

    public function edit($encryptId)
    {
        $id = decrypt($encryptId);
        $user = auth()->user();
        $jenisTransaksi = $this->serviceEstimasi->dataJenisTransaksi();
        $dataCase = $this->repairCaseService->findCase($id);
        $divisiName = $this->nameDivisi->getDivisi($user);

        return view('repair.estimasi.edit.ubah-estimasi-biaya', [
            'title' => 'List Estimasi Biaya',
            'active' => 'konfirmasi-estimasi',
            'navActive' => 'estimasi',
            'divisi' => $divisiName,
            'dataCase' => $dataCase,
            'jenisTransaksi' => $jenisTransaksi,
        ]);

    }

    public function update(Request $request, $id)
    {
        $resultUpdate = $this->serviceEstimasi->ubahEstimasi($request, $id);

        if ($resultUpdate == 'success') {
            return redirect()->route('konfirmasi-biaya.index')->with('success', $resultUpdate['message']);
        } else {
            return back()->with('error', $resultUpdate['message']);
        }
    }

}
