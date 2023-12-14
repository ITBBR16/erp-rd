<?php

namespace App\Http\Controllers\kios;

use App\Http\Controllers\Controller;
use App\Repositories\kios\KiosRepository;

class KiosShopController extends Controller
{
    public function __construct(private KiosRepository $suppKiosRepo){}

    public function index()
    {
        $user = auth()->user();
        $divisiName = $this->suppKiosRepo->getDivisi($user);

        return view('kios.shop.index', [
            'title' => 'Shop',
            'active' => 'shop',
            'dropdown' => '',
            'divisi' => $divisiName,
        ]);
    }
}
