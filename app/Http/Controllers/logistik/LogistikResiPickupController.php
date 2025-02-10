<?php

namespace App\Http\Controllers\logistik;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\logistik\LogistikServices;

class LogistikResiPickupController extends Controller
{
    public function __construct(
        private LogistikServices $logService
    ){}

    public function index()
    {
        return $this->logService->indexPIR();
    }

    public function store(Request $request)
    {
        $result = $this->logService->storePIR($request);
        return back()->with($result['status'], $result['message']);
    }

    public function getDataByEkspedisi($status, $id)
    {
        return $this->logService->getDataByEkspedisi($status, $id);
    }
}
