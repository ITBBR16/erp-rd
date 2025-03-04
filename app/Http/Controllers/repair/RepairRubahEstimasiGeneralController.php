<?php

namespace App\Http\Controllers\repair;

use App\Http\Controllers\Controller;
use App\Services\repair\RepairEstimasiService;
use Illuminate\Http\Request;

class RepairRubahEstimasiGeneralController extends Controller
{
    public function __construct(
        private RepairEstimasiService $estimasiService
    ){}

    public function index()
    {
        return $this->estimasiService->indexRubahEstimasi();
    }

    public function update(Request $request, $id)
    {

    }
}
