<?php

namespace App\Http\Controllers\kios;

use App\Http\Controllers\Controller;
use App\Repositories\kios\KiosRepository;

class DashboardKiosController extends Controller
{
    public function __construct(private KiosRepository $suppKiosRepo){}

    public function index()
    {
        $user = auth()->user();
        $divisiName = $this->suppKiosRepo->getDivisi($user);

        return view('kios.main.index', [
            'title' => 'Kios',
            'active' => 'dashboard-kios',
            'dropdown' => '',
            'dropdownShop' => '',
            'divisi' => $divisiName,
        ]);
    }
}
