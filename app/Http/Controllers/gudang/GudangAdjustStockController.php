<?php

namespace App\Http\Controllers\gudang;

use App\Http\Controllers\Controller;
use App\Services\gudang\GudangAdjustStockServices;
use Illuminate\Http\Request;

class GudangAdjustStockController extends Controller
{
    public function __construct(
        private GudangAdjustStockServices $adjust
    ){}

    public function index()
    {
        return $this->adjust->index();
    }

    public function store(Request $request)
    {
        $resultAdjust = $this->adjust->storeAdjustStock($request);
        return back()->with($resultAdjust['status'], $resultAdjust['message']);
    }
}
