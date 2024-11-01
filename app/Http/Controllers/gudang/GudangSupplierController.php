<?php

namespace App\Http\Controllers\gudang;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\umum\UmumRepository;

class GudangSupplierController extends Controller
{
    public function __construct(private UmumRepository $nameDivisi){}

    public function index()
    {
        $user = auth()->user();
        $divisiName = $this->nameDivisi->getDivisi($user);
        
        return view('gudang.purchasing.supplier.supplier', [
            'title' => 'Gudang Supplier',
            'active' => 'gudang-supplier',
            'navActive' => 'purchasing',
            'divisi' => $divisiName,
        ]);
    }
}
