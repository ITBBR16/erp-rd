<?php

namespace App\Http\Controllers\kios;

use Exception;
use Illuminate\Http\Request;
use Termwind\Components\Raw;
use App\Models\kios\KiosProduk;
use App\Models\produk\ProdukType;
use App\Http\Controllers\Controller;
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
        $produk = KiosProduk::with('subjenis', 'serialnumber')->get()->sortByDesc(function ($produk) {
            return $produk->status == 'Promo' ? 1 : 0;
        });;
        $kategori = ProdukKategori::all();
        $types = ProdukType::all();

        return view('kios.product.index', [
            'title' => 'Product',
            'active' => 'product',
            'navActive' => 'product',
            'dropdown' => 'list-produk',
            'dropdownShop' => '',
            'divisi' => $divisiName,
            'produks' => $produk,
            'kategoriProduk' => $kategori,
            'typeProduks' => $types,
        ]);
    }

    public function update(Request $request, $id)
    {
        try{
            $srp = preg_replace("/[^0-9]/", "", $request->input('harga_jual'));
            $harga_promo = preg_replace("/[^0-9]/", "", $request->input('harga_promo'));
            $start_promo = $request->input('start_date');
            $end_promo = $request->input('end_date');

            $product = KiosProduk::find($id);
            $product->srp = $srp;

            if($end_promo != '') {
                $product->harga_promo = $harga_promo;
                $product->start_promo = $start_promo;
                $product->end_promo = $end_promo;
                $product->status = 'Promo';
            }

            $product->save();

            return back()->with('success', 'Success Update Product.');

        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $productBaruKios = KiosProduk::findOrFail($id);
            $productBaruKios->delete();

            return back()->with('success', 'Success Delete Product.');
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function updateSrpBaru(Request $request)
    {
        $productSecondId = $request->input('productId');
        $newSrp = $request->input('newSrp');

        $productSecond = KiosProduk::findOrFail($productSecondId);
        $productSecond->srp = $newSrp;
        $productSecond->save();
    }

    public function getPaketPenjualan($paketPenjualanId)
    {
        $ddPaketPenjualan = ProdukSubJenis::where('jenis_id', $paketPenjualanId)->get();

        if(count($ddPaketPenjualan) > 0) {
            return response()->json($ddPaketPenjualan);
        }
    }

}
