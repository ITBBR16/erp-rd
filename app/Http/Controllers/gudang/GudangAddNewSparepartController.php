<?php

namespace App\Http\Controllers\gudang;

use App\Http\Controllers\Controller;
use App\Services\gudang\GudangAddNewSparepartServices;
use Illuminate\Http\Request;

class GudangAddNewSparepartController extends Controller
{
    public function __construct(
        private GudangAddNewSparepartServices $addSku
    ){}

    public function index()
    {
        return $this->addSku->index();
    }

    public function store(Request $request)
    {
        $resultSparepart = $this->addSku->createSparepart($request);

        return back()->with($resultSparepart['status'], $resultSparepart['message']);
    }
}
