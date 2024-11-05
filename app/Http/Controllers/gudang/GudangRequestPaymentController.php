<?php

namespace App\Http\Controllers\gudang;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\umum\UmumRepository;
use App\Services\gudang\GudangRequestPaymentService;

class GudangRequestPaymentController extends Controller
{
    public function __construct(
        private GudangRequestPaymentService $reqPaymentService
    ){}

    public function index()
    {
        return $this->reqPaymentService->index();
    }

    public function store(Request $request)
    {
        $resultReqPayment = $this->reqPaymentService->addNewRP($request);

        if ($resultReqPayment['status'] == 'success') {
            return back()->with('success', $resultReqPayment['message']);
        } else {
            return back()->with('error', $resultReqPayment['message']);
        }
    }
}
