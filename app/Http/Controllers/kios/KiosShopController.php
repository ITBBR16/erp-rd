<?php

namespace App\Http\Controllers\kios;

use App\Http\Controllers\Controller;
use App\Models\kios\SupplierKios;
use App\Models\produk\ProdukJenis;
use App\Models\produk\ProdukSubJenis;
use App\Repositories\kios\KiosRepository;
use Clockwork\Request\Request;

class KiosShopController extends Controller
{
    public function __construct(private KiosRepository $suppKiosRepo){}

    public function index()
    {
        $user = auth()->user();
        $divisiName = $this->suppKiosRepo->getDivisi($user);
        $supplier = SupplierKios::all();
        $jenisProduk = ProdukJenis::all();
        $paketPenjualan = ProdukSubJenis::all();

        return view('kios.shop.index', [
            'title' => 'Shop',
            'active' => 'shop',
            'dropdown' => '',
            'divisi' => $divisiName,
            'supplier' => $supplier,
            'jenisProduk' => $jenisProduk,
            'paketPenjualan' => $paketPenjualan,
        ]);
    }

    public function store(Request $request)
    {
        
    }
}
