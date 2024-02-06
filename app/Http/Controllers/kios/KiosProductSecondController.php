<?php

namespace App\Http\Controllers\kios;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\kios\KiosProdukSecond;
use App\Repositories\kios\KiosRepository;

class KiosProductSecondController extends Controller
{
    public function __construct(private KiosRepository $suppKiosRepo){}

    public function index()
    {
        $user = auth()->user();
        $divisiName = $this->suppKiosRepo->getDivisi($user);
        $produkSeconds = KiosProdukSecond::with('subjenis');

        return view('kios.product.produk-second', [
            'title' => 'Product Second',
            'active' => 'product-second',
            'dropdown' => true,
            'dropdownShop' => '',
            'divisi' => $divisiName,
            'produkseconds' => $produkSeconds,
        ]);
    }

}
