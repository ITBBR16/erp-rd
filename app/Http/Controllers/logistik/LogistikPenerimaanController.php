<?php

namespace App\Http\Controllers\logistik;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\logistik\LogistikRepairServices;

class LogistikPenerimaanController extends Controller
{
    public function __construct(
        private LogistikRepairServices $penerimaan
    ){}

    public function index()
    {
        return $this->penerimaan->indexPenerimaan();
    }

    public function update($noRegister)
    {
        $resultKonfirmasi = $this->penerimaan->konfirmasiPenerimaan($noRegister);
        return back()->with($resultKonfirmasi['status'], $resultKonfirmasi['message']);
    }

    public function store(Request $request)
    {
        $resultKonfirmasi = $this->penerimaan->manualForm($request);
        return back()->with($resultKonfirmasi['status'], $resultKonfirmasi['message']);
    }

}
