<?php

namespace App\Http\Controllers\logistik;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\logistik\LogistikRepairServices;

class LogistikRequestPaymentController extends Controller
{
    public function __construct(
        private LogistikRepairServices $penerimaan
    ){}

    public function index()
    {
        
    }
}
