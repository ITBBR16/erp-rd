<?php

namespace App\Http\Controllers\repair;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\umum\UmumRepository;
use App\Services\repair\RepairCaseService;
use App\Services\repair\RepairEstimasiService;

class RepairEstimasiBiayaController extends Controller
{
    public function __construct(
        private RepairEstimasiService $serviceEstimasi)
    {}

    public function index()
    {
        return $this->serviceEstimasi->index();
    }

    public function edit($encryptId)
    {
        return $this->serviceEstimasi->pageEstimasi($encryptId);
    }

    public function update(Request $request, $id)
    {
        $resultEstimasi = $this->serviceEstimasi->createEstimasi($request, $id);

        if ($resultEstimasi['status'] === 'success') {
            return redirect()->route('estimasi-biaya.index')->with($resultEstimasi['status'], $resultEstimasi['message']);
        } else {
            return back()->with($resultEstimasi['status'], $resultEstimasi['message']);
        }
    }

    public function inputJurnalEstimasi(Request $request)
    {
        $resultJurnal = $this->serviceEstimasi->addJurnalEstimasi($request);
        return back()->with($resultJurnal['status'], $resultJurnal['message']);
    }

    public function getJenisDrone()
    {
        return $this->serviceEstimasi->getJenisDrone();
    }

    public function getPartGudang($jenisDrone)
    {
        return $this->serviceEstimasi->getNamaPart($jenisDrone);
    }

    public function getDetailGudang($jenisTransaksi, $sku)
    {
        return $this->serviceEstimasi->getDetailPart($jenisTransaksi, $sku);
    }

}
