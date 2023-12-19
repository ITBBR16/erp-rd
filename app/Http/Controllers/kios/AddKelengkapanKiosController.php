<?php

namespace App\Http\Controllers\kios;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\produk\ProdukJenis;
use App\Http\Controllers\Controller;
use App\Models\produk\ProdukKategori;
use App\Models\produk\ProdukKelengkapan;
use App\Models\produk\ProdukSubJenis;
use App\Repositories\kios\KiosRepository;
use Exception;

class AddKelengkapanKiosController extends Controller
{
    public function __construct(private KiosRepository $suppKiosRepo){}

    public function index()
    {
        $user = auth()->user();
        $divisiName = $this->suppKiosRepo->getDivisi($user);
        $jenis_produk = ProdukJenis::all();
        $kategori = ProdukKategori::all();
        $kelengkapan = ProdukKelengkapan::all();

        return view('kios.product.add-produk', [
            'title' => 'Add Product',
            'active' => 'add-product',
            'dropdown' => true,
            'dropdownShop' => '',
            'divisi' => $divisiName,
            'kategori' => $kategori,
            'jenis_produk' => $jenis_produk,
            'kelengkapan' => $kelengkapan,
        ]);
    }

    public function store(Request $request)
    {
        if($request->has('kategori_id')) {

            $validate = $request->validate([
                'kategori_id' => 'required',
                'jenis_produk' => ['required', Rule::unique('rumahdrone_produk.produk_jenis', 'jenis_produk')],
            ]);
            
            $validate['jenis_produk'] = strtoupper($validate['jenis_produk']);
            
            try {
                $type = ProdukJenis::create($validate);
            
                $jenisKelengkapan = collect($request->jenis_kelengkapan)->map(function ($jk) {
                    return ['kelengkapan' => ucwords(strtolower($jk))];
                });
            
                $type->kelengkapans()->createMany($jenisKelengkapan->toArray());
            
                return back()->with('success', 'Success Add New Product.');
            
            } catch (Exception $e) {
                return back()->with('error', $e->getMessage());
            }
            
        } elseif($request->has('paket_penjualan')) {

            $validatePenjualan = $request->validate([
                'jenis_id' => 'required',
                'paket_penjualan' => 'required',
                'kelengkapan' => 'required|array',
                'quantity' => 'required|array',
            ]);

            $validatePenjualan['paket_penjualan'] = strtoupper($validatePenjualan['paket_penjualan']);

            try{
                $produkJenis = ProdukSubJenis::create([
                    'jenis_id' => $request->jenis_id,
                    'paket_penjualan' => $validatePenjualan['paket_penjualan'],
                ]);

                $kelengkapanId = $request->input('kelengkapan');
                $quantityVal = $request->input('quantity');

                foreach ($kelengkapanId as $index => $id) {
                    $produkJenis->kelengkapans()->attach($id, ['quantity' => $quantityVal[$index]]);
                }

                return back()->with('success', 'Success Add Paket Penjualan.');

            } catch(Exception $e){
                return back()->with('error', $e->getMessage());
            }

        } else {

        }
    }

    public function getKelengkapan($jenisId)
    {
        $ddKelengkapan = ProdukKelengkapan::where('produk_jenis_id', $jenisId)->get();

        if(count($ddKelengkapan) > 0) {
            return response()->json($ddKelengkapan);
        }
    }

}
