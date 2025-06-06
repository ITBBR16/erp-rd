<?php

namespace App\Http\Controllers\kios;

use Exception;
use Illuminate\Http\Request;
use App\Models\kios\KiosProduk;
use App\Models\produk\ProdukType;
use App\Models\produk\ProdukJenis;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\produk\ProdukKategori;
use App\Models\produk\ProdukSubJenis;
use App\Models\produk\ProdukKelengkapan;
use App\Repositories\kios\KiosRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class KiosProductController extends Controller
{
    public function __construct(private KiosRepository $suppKiosRepo){}

    public function index()
    {
        $user = auth()->user();
        $divisiName = $this->suppKiosRepo->getDivisi($user);

        $produk = KiosProduk::orderByRaw("
                        CASE 
                            WHEN status = 'Promo' THEN 1 
                            WHEN status = 'Ready' THEN 2 
                            WHEN status = 'Not Ready' THEN 3 
                            ELSE 4 
                        END
                    ")
                    ->orderBy('updated_at', 'desc')
                    ->paginate(30);
        $kategori = ProdukKategori::all();
        $types = ProdukType::all();
        $jenisProduk = ProdukJenis::all();
        $kelengkapans = ProdukKelengkapan::all();

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

    public function edit($encryptId)
    {
        $id = decrypt($encryptId);
        $user = auth()->user();
        $divisiName = $this->suppKiosRepo->getDivisi($user);
        $dataProduk = KiosProduk::find($id);
        $jenisProduk = ProdukJenis::all();

        return view('kios.product.edit.edit-new-product', [
            'title' => 'Edit Product',
            'active' => 'product',
            'navActive' => 'product',
            'dropdown' => 'list-produk',
            'dropdownShop' => '',
            'divisi' => $divisiName,
            'dataProduk' => $dataProduk,
            'jenisproduks' => $jenisProduk,
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
            $editJenisProduk = $request->input('edit_jenis_produk_baru', []);
            $editPaketPenjualanId = $request->input('edit_paket_penjualan_produk_baru_id');
            $editPaketPenjualan = $request->input('edit_paket_penjualan_produk_baru');
            $editBeratProduk = $request->input('berat_edit_produk_baru');
            $editPanjangProduk = $request->input('length');
            $editLebarProduk = $request->input('width');
            $editTinggiProduk = $request->input('height');
            $editKelengkapanProduk = $request->input('edit_kelengkapan_produk_baru', []);
            $editQuantityProduk = $request->input('edit_quantity_produk_baru', []);

            // Validasi panjang array quantity dan kelengkapan
            if (count($editKelengkapanProduk) !== count($editQuantityProduk)) {
                throw new \Exception('Jumlah kelengkapan dan quantity tidak sesuai.');
            }

            $subJenisKelengkapan = ProdukSubJenis::findOrFail($editPaketPenjualanId);
            $subJenisKelengkapan->update([
                'paket_penjualan' => $editPaketPenjualan,
                'berat' => $editBeratProduk,
                'panjang' => $editPanjangProduk,
                'lebar' => $editLebarProduk,
                'tinggi' => $editTinggiProduk,
            ]);

            // Siapkan data kelengkapan dan quantity
            $syncData = collect($editKelengkapanProduk)->mapWithKeys(function ($id, $index) use ($editQuantityProduk) {
                return [$id => ['quantity' => $editQuantityProduk[$index]]];
            })->toArray();

            $subJenisKelengkapan->kelengkapans()->sync($syncData);

            // Sync produk jenis
            $subJenisKelengkapan->produkjenis()->sync($editJenisProduk);

            // Sync kelengkapan untuk masing-masing produk jenis
            ProdukJenis::whereIn('id', $editJenisProduk)->each(function ($jenis) use ($editKelengkapanProduk) {
                $jenis->kelengkapans()->syncWithoutDetaching($editKelengkapanProduk);
            });

            $connectionProduk->commit();
            return back()->with('success', 'Success update detail product.');

        } catch (ModelNotFoundException $e) {
            $connectionProduk->rollBack();
            return back()->with('error', 'Produk atau SubJenis tidak ditemukan.');
        } catch (\Exception $e) {
            $connectionProduk->rollBack();
            Log::error('Update Produk Gagal: ' . $e->getMessage());
            return back()->with('error', 'Gagal memperbarui produk: ' . $e->getMessage());
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
