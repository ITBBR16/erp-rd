<?php

namespace App\Services\gudang;

use App\Repositories\umum\UmumRepository;

class GudangReturSparepartServices
{
    public function __construct(
        private UmumRepository $umum
    ){}

    public function index()
    {
        $user = auth()->user();
        $divisiName = $this->umum->getDivisi($user);
        
        return view('gudang.distribusi-produk.retur.retur-sparepart', [
            'title' => 'Gudang Retur Sparepart',
            'active' => 'gudang-retur',
            'navActive' => 'distribusi',
            'divisi' => $divisiName
        ]);
    }
}