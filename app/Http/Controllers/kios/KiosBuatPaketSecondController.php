<?php

namespace App\Http\Controllers\kios;

use Illuminate\Http\Request;
use App\Models\produk\ProdukJenis;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\kios\KiosProdukSecond;
use App\Models\kios\KiosQcProdukSecond;
use App\Models\produk\ProdukKelengkapan;
use App\Repositories\kios\KiosRepository;
use Exception;

class KiosBuatPaketSecondController extends Controller
{
    public function __construct(private KiosRepository $suppKiosRepo){}

    public function index()
    {
        $user = auth()->user();
        $divisiName = $this->suppKiosRepo->getDivisi($user);
        $dataKelengkapan = KiosQcProdukSecond::with('kelengkapans')->get();
        $kiosProduks = ProdukJenis::with('subjenis.kelengkapans')->get();
        
        return view('kios.product.add-produk-second', [
            'title' => 'Create Paket Second',
            'active' => 'create-paket-second',
            'dropdown' => '',
            'dropdownShop' => '',
            'divisi' => $divisiName,
            'kelengkapansecond' => $dataKelengkapan,
            'kiosproduks' => $kiosProduks,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'paket_penjualan_produk_second' => 'required',
            'cc_produk_second' => 'required',
            'modal_produk_second' => 'required|min:1',
            'harga_jual_produk_second' => 'required',
            'kelengkapan_second' => 'required|array',
        ]);

        try {
            $srpSecond = preg_replace("/[^0-9]/", "", $request->input('harga_jual_produk_second'));
            $snSecond = $request->input('sn_second');

            if(count(array_unique($snSecond)) !== count($snSecond)) {
                return back()->with('error', 'Serial Number tidak boleh ada yang sama.');
            }

            $produkSecond = KiosProdukSecond::create([
                'sub_jenis_id' => $request->input('paket_penjualan_produk_second'),
                'srp' => $srpSecond,
                'cc_produk_second' => $request->input('cc_produk_second'),
                'status' => 'Ready',
            ]);

            foreach($snSecond as $item) {
                DB::connection('rumahdrone_produk')
                        ->table('kios_kelengkapan_second_list')
                        ->where('pivot_qc_id', $item)
                        ->update(['kios_produk_second_id' => $produkSecond->id, 'status' => 'On Sell']);
            }

            return back()->with('success', 'Success Created Product Second.');

        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function getKelengkapanSecond()
    {
        $data = KiosQcProdukSecond::with(['kelengkapans' => function ($query) {
            $query->wherePivot('status', 'Ready');
        }])->get();
    
        return response()->json($data);
    }

    public function getSNSecond($id)
    {
        $data = KiosQcProdukSecond::with(['kelengkapans' => function ($query) use($id) {
            $query->wherePivot('produk_kelengkapan_id', $id)
                  ->wherePivot('status', 'Ready');
        }])->get();
    
        return response()->json($data);
    }

    public function getPriceSecond($id)
    {
        $dataPrice = DB::connection('rumahdrone_produk')
                        ->table('kios_kelengkapan_second_list')
                        ->where('pivot_qc_id', $id)
                        ->pluck('harga_satuan');

        return response()->json($dataPrice);
    }

}
