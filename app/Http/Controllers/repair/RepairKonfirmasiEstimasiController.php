<?php

namespace App\Http\Controllers\repair;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\umum\UmumRepository;
use App\Services\repair\RepairCaseService;
use App\Services\repair\RepairEstimasiService;

class RepairKonfirmasiEstimasiController extends Controller
{
    public function __construct(
        private UmumRepository $nameDivisi, 
        private RepairCaseService $repairCaseService, 
        private RepairEstimasiService $serviceEstimasi)
    {}

    public function index()
    {
        return $this->serviceEstimasi->indexKonfirmasi();
    }

    public function edit($encryptId)
    {
        return $this->serviceEstimasi->pageUbahEstimasi($encryptId);
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
        $resultPesan = $this->serviceEstimasi->kirimPesanKonfirmasiEstimasi($request);
        return back()->with($resultPesan['status'], $resultPesan['message']);
    }

}
