<?php

namespace App\Http\Controllers\logistik;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\logistik\LogistikServices;

class LogistikRequestPaymentController extends Controller
{
    public function __construct(
        private LogistikServices $penerimaan
    ){}

    public function index()
    {
        
    }
}
