<?php

namespace App\Http\Controllers\kios;

use Illuminate\Http\Request;
use App\Models\divisi\Divisi;
use App\Http\Controllers\Controller;
use App\Models\produk\ProdukJenis;
use App\Models\produk\ProdukKategori;
use App\Models\produk\ProdukSubJenis;
use App\Repositories\kios\KiosRepository;

class KiosProductController extends Controller
{
    public function __construct(private KiosRepository $suppKiosRepo){}

    public function index()
    {
        $user = auth()->user();
        $divisiName = $this->suppKiosRepo->getDivisi($user);
        $jenisProduk = ProdukJenis::with('subjenis')->get();
        $paketProduk = ProdukSubJenis::with('kelengkapans')->get();

        return view('kios.product.index', [
            'title' => 'Product',
            'active' => 'product',
            'dropdown' => true,
            'divisi' => $divisiName,
            'paketProduk' => $paketProduk,
            'jenisProduk' => $jenisProduk,
        ]);
    }

    public function update(Request $request, $id)
    {

    }

    public function destroy($id)
    {
        
    }

    public function getPaketPenjualan($paketPenjualanId)
    {
        $ddPaketPenjualan = ProdukSubJenis::where('jenis_id', $paketPenjualanId)->get;

        if(count($ddPaketPenjualan) > 0) {
            return response()->json($ddPaketPenjualan);
        }
    }

}
