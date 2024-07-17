<?php

namespace App\Http\Controllers\kios;

use Exception;
use Illuminate\Http\Request;
use App\Models\kios\KiosProduk;
use App\Models\produk\ProdukType;
use App\Models\produk\ProdukJenis;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\produk\ProdukKategori;
use App\Models\produk\ProdukSubJenis;
use App\Models\produk\ProdukKelengkapan;
use App\Repositories\kios\KiosRepository;

class KiosProductController extends Controller
{
    public function __construct(private KiosRepository $suppKiosRepo){}

    public function index(Request $request)
    {
        $user = auth()->user();
        $divisiName = $this->suppKiosRepo->getDivisi($user);

        $categoriesProduk = $request->input('categories_produk');
        $categoriesPaket = $request->input('categories_paket');

        $query = KiosProduk::query();

        if ($categoriesProduk) {
            $query->whereHas('subjenis.produkjenis', function($query) use ($categoriesProduk) {
                $query->whereIn('kategori_id', $categoriesProduk);
            });
        }

        if ($categoriesPaket) {
            $query->whereHas('subjenis', function($query) use ($categoriesPaket) {
                $query->whereIn('produk_type_id', $categoriesPaket);
            });
        }

        if (!$categoriesProduk && !$categoriesPaket) {
            $query->with('subjenis', 'serialnumber');
        }

        $produk = $query->get();

        $kategori = ProdukKategori::all();
        $types = ProdukType::all();
        $jenisProduk = ProdukJenis::all();
        $kelengkapans = ProdukKelengkapan::all();

        if ($request->ajax()) {
            return response()->json(view('kios.product.product_table', compact('produk'))->render());
        }

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
            'jenisproduks' => $jenisProduk,
            'kelengkapans' => $kelengkapans,
        ]);
    }

    public function update(Request $request, $id)
    {
        $connectionKios = DB::connection('rumahdrone_kios');
        $connectionKios->beginTransaction();
        try{
            $srp = preg_replace("/[^0-9]/", "", $request->input('harga_jual'));
            $harga_promo = preg_replace("/[^0-9]/", "", $request->input('harga_promo'));
            $start_promo = $request->input('start_date');
            $end_promo = $request->input('end_date');

            $product = KiosProduk::find($id);
            $product->srp = $srp;

            if($start_promo != '' && $end_promo != '') {
                $product->harga_promo = $harga_promo;
                $product->start_promo = $start_promo;
                $product->end_promo = $end_promo;
                $product->status = 'Promo';
            }

            $product->save();

            $connectionKios->commit();
            return back()->with('success', 'Success Update Product.');

        } catch (Exception $e) {
            $connectionKios->rollBack();
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

    public function updateProdukBaru(Request $request)
    {
        $connectionProduk = DB::connection('rumahdrone_produk');
        $connectionProduk->beginTransaction();
        try {
            $editJenisProduk = $request->input('edit_jenis_produk_baru');
            $editPaketPenjualanId = $request->input('edit_paket_penjualan_produk_baru_id');
            $editPaketPenjualan = $request->input('edit_paket_penjualan_produk_baru');
            $editBeratProduk = $request->input('berat_edit_produk_baru');
            $editPanjangProduk = $request->input('length');
            $editLebarProduk = $request->input('width');
            $editTinggiProduk = $request->input('height');
            $editKelengkapanProduk = $request->input('edit_kelengkapan_produk_baru');
            $editQuantityProduk = $request->input('edit_quantity_produk_baru');

            $subJenisKelengkapan = ProdukSubJenis::findOrFail($editPaketPenjualanId);
            $subJenisKelengkapan->update([
                'paket_penjualan' => $editPaketPenjualan,
                'berat' => $editBeratProduk,
                'panjang' => $editPanjangProduk,
                'lebar' => $editLebarProduk,
                'tinggi' => $editTinggiProduk,
            ]);

            $syncData = [];
            foreach ($editKelengkapanProduk as $index => $kelengkapan) {
                $syncData[$kelengkapan] = ['quantity' => $editQuantityProduk[$index]];
            }

            $subJenisKelengkapan->kelengkapans()->sync($syncData);

            $currentProdukJenis = $subJenisKelengkapan->produkjenis->pluck('id')->toArray();
            $removedJenis = array_diff($currentProdukJenis, $editJenisProduk);

            if (!empty($removedJenis)) {
                ProdukJenis::whereIn('id', $removedJenis)->each(function ($jenis) use ($editKelengkapanProduk) {
                    $jenis->kelengkapans()->detach($editKelengkapanProduk);
                });
            }

            $subJenisKelengkapan->produkjenis()->sync($editJenisProduk);

            foreach ($editJenisProduk as $jenisId) {
                ProdukJenis::find($jenisId)->kelengkapans()->sync($editKelengkapanProduk);
            }

            $connectionProduk->commit();
            return back()->with('success', 'Success update detail product.');

        } catch (Exception $e) {
            $connectionProduk->rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    public function getPaketPenjualan($paketPenjualanId)
    {
        $ddPaketPenjualan = ProdukSubJenis::where('id', $paketPenjualanId)->get();

        if(count($ddPaketPenjualan) > 0) {
            return response()->json($ddPaketPenjualan);
        }
    }

    public function getKelengkapans($id)
    {
        $searchSub = ProdukSubJenis::find($id);
        $kelengkapans = $searchSub->allKelengkapans();

        return $kelengkapans;
    }

}
