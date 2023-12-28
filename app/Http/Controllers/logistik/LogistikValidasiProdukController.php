<?php

namespace App\Http\Controllers\logistik;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\umum\UmumRepository;

class LogistikValidasiProdukController extends Controller
{
    public function __construct(private UmumRepository $umumRepo){}

    public function index()
    {
        $user = auth()->user();
        $divisiName = $this->umumRepo->getDivisi($user);

        return view('logistik.main.validasi.index', [
            'title' => 'Validasi Barang',
            'active' => 'validasi',
            'divisi' => $divisiName,
        ]);
    }
}
