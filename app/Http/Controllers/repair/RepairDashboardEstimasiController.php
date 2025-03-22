<?php

namespace App\Http\Controllers\repair;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\repair\RepairDashboardEstimasiServices;

class RepairDashboardEstimasiController extends Controller
{
    public function __construct(
        private RepairDashboardEstimasiServices $dashboardService
    ){}

    public function index()
    {
        return $this->dashboardService->index();
    }
}
