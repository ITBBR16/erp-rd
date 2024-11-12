<?php

namespace App\Http\Controllers\gudang;

use App\Http\Controllers\Controller;
use App\Services\gudang\GudangValidasiServices;
use Illuminate\Http\Request;

class GudangValidasiQCController extends Controller
{
    public function __construct(
        private GudangValidasiServices $validasi
    ){}

    public function index()
    {
        return $this->validasi->index();
    }

    public function store(Request $request)
    {
        $resultValidasi = $this->validasi->createValidasi($request);

        if ($resultValidasi['status'] == 'success') {
            return redirect()->route('gudang-validasi.index')->with('success', $resultValidasi['message']);
        } else {
            return back()->with('error', $resultValidasi['message']);
        }
    }

    public function pageValidasi($idBelanja, $idProduk)
    {
        return $this->validasi->validasiPage($idBelanja, $idProduk);
    }
}
