<?php

namespace App\Http\Controllers\repair;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\repair\RepairTeknisiService;

class RepairPengerjaanController extends Controller
{
    public function __construct(
        private RepairTeknisiService $repairTeknisi)
    {}

    public function index()
    {
        return $this->repairTeknisi->indexPengerjaan();
    }

    public function detailPengerjaan($encryptId)
    {
        return $this->repairTeknisi->pageDetailPengerjaan($encryptId);
    }

    public function update(Request $request, $id)
    {
        $resultJurnal = $this->repairTeknisi->createJurnalPengerjaan($request, $id);
        return back()->with($resultJurnal['status'], $resultJurnal['message']);
    }

    public function changeStatusPengerjaan($id)
    {
        $resultStatus = $this->repairTeknisi->changeStatusPengerjaan($id);
        return back()->with($resultStatus['status'], $resultStatus['message']);
    }
}
