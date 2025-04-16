<?php

namespace App\Http\Controllers\logistik;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\logistik\LogistikServices;

class LogistikRequestPackingController extends Controller
{
    public function __construct(
        private LogistikServices $logService
    ){}

    public function index()
    {
        return $this->logService->indexFRP();
    }

    public function getCustomer($id)
    {
        return $this->logService->getCustomer($id);
    }

    public function store(Request $request)
    {
        $result = $this->logService->storeReqPacking($request);
        return back()->with($result['status'], $result['message']);
    }

    public function getLayanan($id)
    {
        return $this->logService->getLayanan($id);
    }
}
