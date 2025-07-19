<?php

namespace App\Http\Controllers\gudang;

use App\Http\Controllers\Controller;
use App\Services\gudang\GudangRequestPaymentService;
use Illuminate\Http\Request;

class GudangKonfirmasiPembayaran extends Controller
{
    public function __construct(
        private GudangRequestPaymentService $reqPaymentService
    ) {}

    public function index()
    {
        return $this->reqPaymentService->konfirmasiIndex();
    }

    public function store(Request $request)
    {
        $resultPayment = $this->reqPaymentService->konfirmasiUpdate($request);

        return back()->with($resultPayment['status'], $resultPayment['message']);
    }
}
