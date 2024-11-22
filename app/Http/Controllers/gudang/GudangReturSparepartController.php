<?php

namespace App\Http\Controllers\gudang;

use App\Http\Controllers\Controller;
use App\Services\gudang\GudangReturSparepartServices;
use Illuminate\Http\Request;

class GudangReturSparepartController extends Controller
{
    public function __construct(
        private GudangReturSparepartServices $retur
    ){}

    public function index()
    {
        return $this->retur->index();
    }
}
