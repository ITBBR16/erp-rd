<?php

namespace App\Http\Controllers\kios;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\produk\ProdukJenis;
use App\Repositories\kios\KiosRepository;

class AddKelengkapanKiosController extends Controller
{
    public function __construct(private KiosRepository $suppKiosRepo){}

    public function index()
    {
        $user = auth()->user();
        $divisiName = $this->suppKiosRepo->getDivisi($user);
        $jenis_produk = ProdukJenis::all();

        return view('kios.product.add-produk', [
            'title' => 'Add Product',
            'active' => 'add-product',
            'dropdown' => true,
            'divisi' => $divisiName,
            'jenis_produk' => $jenis_produk,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'jenis_id' => 'required',
            'paket_penjualan' => 'required',
            'kelengkapan' => 'array'
        ]);
    }
}
