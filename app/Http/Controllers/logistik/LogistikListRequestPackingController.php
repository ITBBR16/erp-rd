<?php

namespace App\Http\Controllers\logistik;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\logistik\LogistikServices;

class LogistikListRequestPackingController extends Controller
{
    public function __construct(
        private LogistikServices $logistikServices
    ){}

    public function index()
    {
        return $this->logistikServices->indexLRP();
    }

    public function reviewPdf($encryptId)
    {
        $pdf = $this->logistikServices->previewLabel($encryptId);
        return $pdf->stream();
    }

    public function store(Request $request)
    {
        $result = $this->logistikServices->storeLRP($request);

        return back()->with($result['status'], $result['message']);
    }

}
