<?php

namespace App\Http\Controllers\kios;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\kios\KiosProdukSecond;
use App\Models\produk\ProdukSubJenis;
use App\Repositories\kios\KiosRepository;
use App\Models\produk\KiosKelengkapanSecondList;

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

        $serialNumberMap = $kelengkapanSecond
                            ->groupBy('produk_kelengkapan_id')
                            ->map(function ($items) {
                                return $items->map(function ($item) {
                                    return [
                                        'pivot_qc_id' => $item->pivot_qc_id,
                                        'serial_number' => $item->serial_number,
                                    ];
                                })->values();
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
            'serialNumberMap' => $serialNumberMap,
        ]);
    }

    public function update(Request $request, $id)
    {
        try {
            $connectionProduk = DB::connection('rumahdrone_produk');
            $connectionKios = DB::connection('rumahdrone_kios');
            $connectionProduk->beginTransaction();
            $connectionKios->beginTransaction();

            $produkSecond = KiosProdukSecond::findOrFail($id);
            $paketPenjualan = $request->input('paket_penjualan_produk_second');
            $ccProduk = $request->input('edit_cc_produk_second');
            $serialNumberPaket = $request->input('edit_serial_number_second');
            $garansiBulan = $request->input('garansi_produk_second');
            $modalAwalSecond = preg_replace("/[^0-9]/", "", $request->input('modal_awal_second')) ?: 0;
            $hargaJual = preg_replace("/[^0-9]/", "", $request->input('harga_jual_second')) ?: 0;

            $dataProdukSecond = [
                'sub_jenis_id' => $paketPenjualan,
                'modal_bekas' => $modalAwalSecond,
                'srp' => $hargaJual,
                'cc_produk_second' => $ccProduk,
                'serial_number' => $serialNumberPaket,
                'garansi' => $garansiBulan
            ];
            $produkSecond->update($dataProdukSecond);
            
            $kelengkapanBaru = $request->input('sn_second');
            $kelengkapanLama = $produkSecond->kelengkapanSeconds()->pluck('produk_kelengkapan_id')->toArray();

            $yangDihapus = array_diff($kelengkapanLama, $kelengkapanBaru);
            $yangDitambah = array_diff($kelengkapanBaru, $kelengkapanLama);

            if (!empty($yangDihapus)) {
                KiosKelengkapanSecondList::whereIn('id', $yangDihapus)
                    ->update([
                        'status' => 'Ready',
                        'kios_produk_second_id' => null,
                    ]);
            }

            if (!empty($yangDitambah)) {
                KiosKelengkapanSecondList::whereIn('id', $yangDitambah)
                    ->update([
                        'status' => 'On Sell',
                        'kios_produk_second_id' => $id,
                    ]);
            }

            $connectionProduk->commit();
            $connectionKios->commit();

            return redirect()->route('list-product-second.index')->with('success', 'Berhasil merubah data produk second.');
        } catch (Exception $e) {
            $connectionProduk->rollBack();
            return back()->with('error', $e->getMessage());
        }
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
