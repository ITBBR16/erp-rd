<?php

namespace App\Http\Controllers\repair;

use App\Http\Controllers\Controller;
use App\Services\repair\RepairEstimasiService;
use Illuminate\Http\Request;

class RepairRubahEstimasiGeneralController extends Controller
{
    public function __construct(
        private RepairEstimasiService $estimasiService
    ){}

    public function index()
    {
        return $this->estimasiService->indexRubahEstimasi();
    }

    public function edit($encryptId)
    {
        return $this->estimasiService->pageGeneralUbah($encryptId);
    }

    public function update(Request $request, $id)
    {
        $result = $this->estimasiService->ubahEstimasiGeneral($request, $id);

        if ($result['status'] == 'success') {
            return redirect()->route('rubah-estimasi.index')->with($result['status'], $result['message']);
        } else {
            return back()->with($result['status'], $result['message']);
        }
    }
}
