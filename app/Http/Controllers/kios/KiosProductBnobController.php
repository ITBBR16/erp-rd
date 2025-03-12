<?php

namespace App\Http\Controllers\kios;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\kios\KiosProdukBnob;
use App\Repositories\kios\KiosRepository;

class KiosProductBnobController extends Controller
{
    public function __construct(private KiosRepository $suppKiosRepo){}

    public function index()
    {
        $user = auth()->user();
        $divisiName = $this->suppKiosRepo->getDivisi($user);
        $productsBnob = KiosProdukBnob::orderByRaw("
                            CASE 
                                WHEN status = 'Ready' THEN 1
                                WHEN status = 'Sold' THEN 2
                                ELSE 3
                            END
                        ")
                        ->orderBy('updated_at', 'desc')
                        ->paginate(50);

        return view('kios.product.produk-bnob', [
            'title' => 'Product BNOB',
            'active' => 'product-bnob',
            'navActive' => 'product',
            'dropdown' => 'list-produk',
            'dropdownShop' => '',
            'divisi' => $divisiName,
            'productsBnob' => $productsBnob,
        ]);
    }

    public function updateSRPBnob(Request $request)
    {
        $productSecondId = $request->input('productId');
        $newSrp = $request->input('newSrp');

        $productSecond = KiosProdukBnob::findOrFail($productSecondId);
        $productSecond->srp = $newSrp;
        $productSecond->save();
    }
}
