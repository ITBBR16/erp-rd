<?php

namespace App\Http\Controllers\gudang;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\umum\UmumRepository;

class GudangPengirimanBelanjaController extends Controller
{
    public function __construct(private UmumRepository $nameDivisi){}

    public function index()
    {
        $user = auth()->user();
        $divisiName = $this->nameDivisi->getDivisi($user);
        
        return view('gudang.purchasing.pengiriman.pengiriman', [
            'title' => 'Gudang Pengiriman',
            'active' => 'gudang-pengiriman',
            'navActive' => 'purchasing',
            'divisi' => $divisiName,
        ]);
    }
}
