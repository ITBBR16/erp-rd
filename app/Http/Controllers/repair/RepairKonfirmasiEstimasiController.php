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
        $greeting = $this->showTimeForChat();
        $dataCase = $caseService['data_case'];

        return view('repair.estimasi.konfirmasi', [
            'title' => 'List Konfirmasi Estimasi',
            'active' => 'konfirmasi-estimasi',
            'navActive' => 'estimasi',
            'dropdown' => '',
            'divisi' => $divisiName,
            'dataCase' => $dataCase,
            'greeting' => $greeting,
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

        if ($resultUpdate['status'] == 'success') {
            return redirect()->route('konfirmasi-estimasi.index')->with('success', $resultUpdate['message']);
        } else {
            return back()->with('error', $resultUpdate['message']);
        }
    }

    public function addJurnalKonfirmasi(Request $request)
    {
        $resultJurnal = $this->serviceEstimasi->addJurnalKonfirmasi($request);
        return back()->with($resultJurnal['status'], $resultJurnal['message']);
    }

    public function konfirmasiEstimasi(Request $request, $id)
    {
        $resultKE = $this->serviceEstimasi->konfirmasiEstimasi($request, $id);
        return back()->with($resultKE['status'], $resultKE['message']);
    }

    public function konfirmasiPengerjaan($id)
    {
        $resultKP = $this->serviceEstimasi->konfirmasiPengerjaan($id);
        return back()->with($resultKP['status'], $resultKP['message']);
    }

    public function kirimPesanEstimasi(Request $request)
    {
        $greeting = $this->showTimeForChat();
        $resultPesan = $this->serviceEstimasi->kirimPesanKonfirmasiEstimasi($request, $greeting);
        return back()->with($resultPesan['status'], $resultPesan['message']);
    }

    public function showTimeForChat()
    {
        $hour = date('H');
        $greeting = '';

        if ($hour >= 5 && $hour < 11) {
            $greeting = 'Pagi';
        } elseif ($hour >= 11 && $hour < 15) {
            $greeting = 'Siang';
        } elseif ($hour >= 15 && $hour < 18) {
            $greeting = 'Sore';
        } else {
            $greeting = 'Malam';
        }

        return $greeting;
    }

}
