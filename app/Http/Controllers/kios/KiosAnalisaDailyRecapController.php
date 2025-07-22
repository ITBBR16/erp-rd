<?php

namespace App\Http\Controllers\kios;

use App\Http\Controllers\Controller;
use App\Services\kios\KiosAnalisaDailyRecapServices;
use Illuminate\Http\Request;

class KiosAnalisaDailyRecapController extends Controller
{
    public function __construct(
        private KiosAnalisaDailyRecapServices $dailyRecap
    ) {}

    public function index()
    {
        return $this->dailyRecap->index();
    }

    public function exportDailyRecap(Request $request)
    {
        return $this->dailyRecap->exportDailyRecap($request);
    }
}
