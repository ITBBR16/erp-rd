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
}
