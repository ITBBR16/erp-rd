<?php

namespace App\Http\Controllers\gudang;

use App\Http\Controllers\Controller;
use App\Services\gudang\GudangQCServices;
use Illuminate\Http\Request;

class GudangQualityControlController extends Controller
{
    public function __construct(
        private GudangQCServices $qc
    ){}

    public function index()
    {
        return $this->qc->index();
    }

    public function cekQcFisik($idBelanja, $idProduk)
    {
        return $this->qc->qcFisik($idBelanja, $idProduk);
    }

    public function cekQcFungsional($idBelanja, $idProduk)
    {
        return $this->qc->qcFungsional($idBelanja, $idProduk);
    }

    public function store(Request $request)
    {
        $resultQcFisik = $this->qc->createResultQcFisik($request);

        if ($resultQcFisik['status'] == 'success') {
            return redirect()->route('gudang-qc.index')->with('success', $resultQcFisik['message']);
        } else {
            return back()->with('error', $resultQcFisik['message']);
        }
    }

    public function storeFungsional(Request $request)
    {
        $resultQcFungsional = $this->qc->createResultQcFungsional($request);

        if ($resultQcFungsional['status'] == 'success') {
            return redirect()->route('gudang-qc.index')->with('success', $resultQcFungsional['message']);
        } else {
            return back()->with('error', $resultQcFungsional['message']);
        }
    }

}
