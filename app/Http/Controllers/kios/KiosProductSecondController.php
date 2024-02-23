<?php

namespace App\Http\Controllers\kios;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\kios\KiosProdukSecond;
use App\Models\kios\KiosQcProdukSecond;
use App\Models\produk\ProdukKelengkapan;
use App\Repositories\kios\KiosRepository;

class KiosProductSecondController extends Controller
{
    public function __construct(private KiosRepository $suppKiosRepo){}

    public function index()
    {
        $user = auth()->user();
        $divisiName = $this->suppKiosRepo->getDivisi($user);
        $sideBar = 'kios.layouts.sidebarProduct';
        $produkSeconds = KiosProdukSecond::with('subjenis')->get();

        return view('kios.product.produk-second', [
            'title' => 'Product Second',
            'active' => 'product-second',
            'navActive' => 'product',
            'dropdown' => 'list-produk',
            'dropdownShop' => '',
            'divisi' => $divisiName,
            'produkseconds' => $produkSeconds,
        ])
        ->with('sidebarLayout', $sideBar);
    }

    public function updateSRPSecond(Request $request)
    {
        $productSecondId = $request->input('productId');
        $newSrp = $request->input('newSrp');

        $productSecond = KiosProdukSecond::findOrFail($productSecondId);
        $productSecond->srp = $newSrp;
        $productSecond->save();
    }

}
