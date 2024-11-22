<?php

namespace App\Http\Controllers\gudang;

use App\Http\Controllers\Controller;
use App\Services\gudang\GudangKomplainSupplierServices;
use Illuminate\Http\Request;

class GudangKomplainSupplierController extends Controller
{
    public function __construct(
        private GudangKomplainSupplierServices $komplain
    ){}

    public function index()
    {
        return $this->komplain->index();
    }
}
