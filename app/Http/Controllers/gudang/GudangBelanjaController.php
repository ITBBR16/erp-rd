<?php

namespace App\Http\Controllers\gudang;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\gudang\GudangBelanjaServices;

class GudangBelanjaController extends Controller
{
    protected $belanjaService;
    public function __construct(GudangBelanjaServices $gudangBelanjaService)
    {
        $this->belanjaService = $gudangBelanjaService;
    }

    public function index()
    {
        $resultIndex = $this->belanjaService->index();
        return $resultIndex;
    }

    public function edit($encryptId)
    {
        $id = decrypt($encryptId);
        $editBelanja = $this->belanjaService->editBelanja($id);
        return $editBelanja;
    }

    public function store(Request $request)
    {
        $resultBelanja = $this->belanjaService->createBelanja($request);

        if ($resultBelanja['status'] == 'success') {
            return back()->with('success', $resultBelanja['message']);
        } else {
            return back()->with('error', $resultBelanja['message']);
        }
    }

    public function update(Request $request, $id)
    {
        $resultUpdate = $this->belanjaService->updateBelanja($id, $request);

        if ($resultUpdate['status'] == 'success') {
            return redirect()->route('belanja-sparepart.index')->with('success', $resultUpdate['message']);
        } else {
            return back()->with('error', $resultUpdate['message']);
        }
    }

    public function requestPaymentBelanja($id)
    {
        $resultPayment = $this->belanjaService->requestPayment($id);

        if ($resultPayment['status'] == 'success') {
            return back()->with('success', $resultPayment['message']);
        } else {
            return back()->with('error', $resultPayment['message']);
        }
    }

    public function getSparepartByJenis($id)
    {
        return $this->belanjaService->getDataSparepart($id);
    }
}
