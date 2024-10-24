<?php

namespace App\Http\Controllers\gudang;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\umum\UmumRepository;

class GudangBelanjaController extends Controller
{
    public function __construct(private UmumRepository $nameDivisi){}

    public function index()
    {
        $user = auth()->user();
        $divisiName = $this->nameDivisi->getDivisi($user);
        
        return view('gudang.purchasing.belanja.belanja', [
            'title' => 'Gudang Belanja',
            'active' => 'gudang-belanja',
            'navActive' => 'purchasing',
            'divisi' => $divisiName,
        ]);
    }
}
