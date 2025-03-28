<?php

namespace App\Http\Controllers\gudang;

use App\Http\Controllers\Controller;
use App\Services\gudang\GudangKonfirmasiPengirimanServices;
use Illuminate\Http\Request;

class GudangKonfirmasiPengirimanController extends Controller
{
    public function __construct(
        private GudangKonfirmasiPengirimanServices $konfirmasi
    ){}

    public function index()
    {
        return $this->konfirmasi->index();
    }

    public function edit($encryptId)
    {
        return $this->konfirmasi->pageKonfirmasi($encryptId);
    }

    public function store(Request $request)
    {
        $resultSendPart = $this->konfirmasi->sendPart($request);

        if ($resultSendPart['status'] == 'success') {
            return redirect()->route('konfirmasi-pengiriman.index')->with($resultSendPart['status'], $resultSendPart['message']);
        } else {
            return back()->with($resultSendPart['status'], $resultSendPart['message']);
        }
    }

    public function checkCountModal($id)
    {
        return $this->konfirmasi->checkCount($id);
    }
}
