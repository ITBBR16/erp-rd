<?php

namespace App\Http\Controllers\gudang;

use App\Http\Controllers\Controller;
use App\Services\gudang\GudangListProdukServices;
use Illuminate\Http\Request;

class GudangListProdukController extends Controller
{
    public function __construct(
        private GudangListProdukServices $produk
    ){}

    public function index()
    {
        return $this->produk->index();
    }

    public function update($id, Request $request)
    {
        $resultProduk = $this->produk->updatePromoProduk($id, $request);

        if ($resultProduk['status'] == 'success') {
            return back()->with('success', $resultProduk['message']);
        } else {
            return back()->with('error', $resultProduk['message']);
        }
    }

    public function updateHarga($id, Request $request)
    {
        $resultHarga = $this->produk->updateHargaJual($id, $request);

        if ($resultHarga['status'] == 'error') {
            return back()->with('error', $resultHarga['message']);
        }
    }

    public function searchListProduk(Request $request)
    {
        return $this->produk->searchListProduk($request);
    }
}
