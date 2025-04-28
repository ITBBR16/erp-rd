<?php

namespace App\Http\Controllers\kios;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\kios\KiosProdukSecond;
use App\Models\produk\KiosKelengkapanSecondList;
use App\Models\produk\ProdukSubJenis;
use App\Repositories\kios\KiosRepository;

class KiosProductSecondController extends Controller
{
    public function __construct(private KiosRepository $suppKiosRepo){}

    public function index()
    {
        $user = auth()->user();
        $divisiName = $this->suppKiosRepo->getDivisi($user);
        $produkSeconds = KiosProdukSecond::orderByRaw("
                            CASE 
                                WHEN status = 'Ready' THEN 1
                                WHEN status = 'Sold' THEN 2
                                ELSE 3
                            END
                        ")
                        ->orderBy('updated_at', 'desc')
                        ->paginate(50);

        return view('kios.product.produk-second', [
            'title' => 'Product Second',
            'active' => 'product-second',
            'navActive' => 'product',
            'dropdown' => 'list-produk',
            'dropdownShop' => '',
            'divisi' => $divisiName,
            'produkseconds' => $produkSeconds,
        ]);
    }

    public function edit($encryptId)
    {
        $id = decrypt($encryptId);
        $divisiName = $this->suppKiosRepo->getDivisi(auth()->user());
        $produkSecond = KiosProdukSecond::findOrFail($id);
        $kiosProduks = ProdukSubJenis::all();
        $dataPaketPenjualan = $kiosProduks->map(function ($produk) {
            return [
                'id' => $produk->id,
                'display' => $produk->paket_penjualan,
            ];
        });
        
        $kelengkapanTerpakai = $produkSecond->kelengkapanSeconds;

        $kelengkapanTerpakaiIds = $kelengkapanTerpakai->pluck('id')->toArray();

        $kelengkapanSecond = KiosKelengkapanSecondList::where(function ($query) use ($kelengkapanTerpakaiIds) {
                $query->where('status', 'Ready')
                    ->orWhereIn('produk_kelengkapan_id', $kelengkapanTerpakaiIds);
            })
            ->get()
            ->unique('produk_kelengkapan_id')
            ->values();

        $serialNumber = $kelengkapanTerpakai->flatMap(function ($kelengkapan) {
            $readyItems = KiosKelengkapanSecondList::where('produk_kelengkapan_id', $kelengkapan->produk_kelengkapan_id)
                ->where('status', 'Ready')
                ->get();

            if (!$readyItems->contains('id', $kelengkapan->id)) {
                $readyItems->push($kelengkapan);
            }

            return $readyItems->map(function ($item) {
                return [
                    'id' => $item->pivot->pivot_qc_id,
                    'serial_number' => $item->pivot->serial_number,
                ];
            });
        });

        return view('kios.product.edit.edit-second-product', [
            'title' => 'Edit Product Second',
            'active' => 'product-second',
            'navActive' => 'product',
            'dropdown' => 'list-produk',
            'dropdownShop' => '',
            'divisi' => $divisiName,
            'produkSecond' => $produkSecond,
            'kiosproduks' => $dataPaketPenjualan,
            'kelengkapanSecond' => $kelengkapanSecond,
            'serialNumber' => $serialNumber,
        ]);
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
