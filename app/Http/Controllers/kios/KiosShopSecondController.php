<?php

namespace App\Http\Controllers\kios;

use Illuminate\Http\Request;
use App\Models\customer\Customer;
use App\Models\produk\ProdukJenis;
use App\Http\Controllers\Controller;
use App\Models\produk\ProdukSubJenis;
use App\Models\produk\ProdukKelengkapan;
use App\Repositories\kios\KiosRepository;
use App\Models\kios\KiosMetodePembelianSecond;
use App\Models\kios\KiosStatusPembayaran;
use Exception;

class KiosShopSecondController extends Controller
{
    public function __construct(private KiosRepository $suppKiosRepo){}

    public function index()
    {
        $user = auth()->user();
        $divisiName = $this->suppKiosRepo->getDivisi($user);
        $metode_pembelian = KiosMetodePembelianSecond::all();
        $statusPembayaran = KiosStatusPembayaran::all();
        $customer = Customer::all();
        $kiosProduk = ProdukJenis::with('subjenis.kelengkapans')->get();
        $kelengkapan = ProdukKelengkapan::all();

        return view('kios.shop.index-second', [
            'title' => 'Shop Second',
            'active' => 'shop-second',
            'divisi' => $divisiName,
            'dropdown' => '',
            'dropdownShop' => true,
            'metodePembelian' => $metode_pembelian,
            'customer' => $customer,
            'produkKios' => $kiosProduk,
            'kelengkapan' => $kelengkapan,
            'statusPembayaran' => $statusPembayaran,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'metode_pembelian' => 'required',
            'customer' => 'required',
            'tanggal_pembelian' => 'required',
            'jenis_drone_seconde' => 'required',
            'status_pembayaran' => 'required',
            'biaya_pembelian' => 'required',
            'kelengkapan_second' => 'required',
            'quantity_second' => 'required',
        ]);

        try{

            

        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }

    }

    public function getKelengkapanSecond($jenisId)
    {
        $subJenis = ProdukSubJenis::findOrFail($jenisId);
        return response()->json(['kelengkapans' => $subJenis->kelengkapans]);
    }
}
