<?php

namespace App\Http\Controllers\logistik;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\logistik\LogistikServices;

class LogistikRequestPaymentController extends Controller
{
    public function __construct(
        private LogistikServices $logistikServices
    ){}

    public function index()
    {
        return $this->logistikServices->indexRP();
    }

    public function store(Request $request)
    {
        $result = $this->logistikServices->storeReqPayment($request);

        return back()->with($result['status'], $result['message']);
    }

    public function getDataReqPayment($id)
    {
        return $this->logistikServices->getDataReqPayment($id);
    }
}
