<?php

namespace App\Http\Controllers\kios;

use Illuminate\Http\Request;
use App\Models\kios\KiosProduk;
use App\Http\Controllers\Controller;
use App\Models\kios\KiosSerialNumber;
use App\Repositories\umum\UmumRepository;

class KiosSplitDroneBaruController extends Controller
{
    public function __construct(
        private UmumRepository $umum
    ){}

    public function index()
    {
        $user = auth()->user();
        $divisiName = $this->umum->getDivisi($user);
        $produk = KiosProduk::where('status', ['Ready', 'Promo'])->get();
        $dataProduk = $produk->map(function ($produk) {
            return [
                'id' => $produk->id,
                'display' => $produk->subjenis->paket_penjualan
            ];
        });

        return view('kios.product.splitbaru.index', [
            'title' => 'Split Drone Baru',
            'active' => 'splitdb',
            'navActive' => 'product',
            'dropdown' => '',
            'dropdownShop' => '',
            'divisi' => $divisiName,
            'produks' => $dataProduk,
        ]);
    }

    public function store(Request $request)
    {

    }

    public function getSnSplit($id)
    {
        $dataSN = KiosSerialNumber::where('produk_id', $id)->where('status', 'Ready')->get();

        return response()->json($dataSN);
    }

    public function getKelengkapanSplitBaru($id, $idSn)
    {
        $produkBaru = KiosProduk::find($id);
        $kelengkapanBaru = $produkBaru->subjenis->kelengkapans;

        $findSn = KiosSerialNumber::find($idSn);
        $nilaiModal = $findSn->validasiproduk->orderLists->nilai;

        return response()->json(['dataKelengkapan' => $kelengkapanBaru, 'modalAwal' => $nilaiModal]);
    }
}
