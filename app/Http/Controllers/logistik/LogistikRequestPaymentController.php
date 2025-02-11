<?php

namespace App\Http\Controllers\logistik;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\logistik\LogistikServices;

class LogistikRequestPaymentController extends Controller
{
    public function __construct(
        private LogistikServices $logistikServices
    ){}

    public function index()
    {
        return $this->logistikServices->indexRP();
    }
}
