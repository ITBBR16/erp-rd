<?php

namespace App\Http\Controllers\gudang;

use App\Http\Controllers\Controller;
use App\Services\gudang\GudangUnboxingServices;
use Illuminate\Http\Request;

class GudangUnboxingController extends Controller
{
    public function __construct(
        private GudangUnboxingServices $unboxing,
    ){}

    public function index()
    {
        return $this->unboxing->index();
    }

    public function update($id, Request $request)
    {
        $resultUnboxing = $this->unboxing->processUnboxing($id, $request);

        if ($resultUnboxing['status'] == 'success') {
            return back()->with('success', $resultUnboxing['message']);
        } else {
            return back()->with('error', $resultUnboxing['message']);
        }
    }
}
