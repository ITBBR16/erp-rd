<?php

namespace App\Http\Controllers\logistik;

use Illuminate\Http\Request;
use App\Models\produk\ProdukJenis;
use App\Http\Controllers\Controller;
use App\Services\logistik\LogistikRepairServices;

class LogistikSentToRepairController extends Controller
{
    public function __construct(
        private LogistikRepairServices $logistikRepair
    ){}

    public function index()
    {
        return $this->logistikRepair->indexSentRepair();
    }

    public function edit($encryptId)
    {
        return $this->logistikRepair->pageValidasi($encryptId);
    }

    public function update($noRegister, Request $request)
    {
        $resultUpdate = $this->logistikRepair->sentToRepair($noRegister, $request);

        if ($resultUpdate['status'] == 'success') {
            return redirect()->route('sent-to-rapair.index')->with($resultUpdate['status'], $resultUpdate['message']);
        } else {
            return back()->with($resultUpdate['status'], $resultUpdate['message']);
        }
    }

    public function getKelengkapan($id)
    {
        $productSearch = ProdukJenis::findOrFail($id);
        $dataKelengkapan = $productSearch->kelengkapans()->get();

        return response()->json($dataKelengkapan);
    }
}
