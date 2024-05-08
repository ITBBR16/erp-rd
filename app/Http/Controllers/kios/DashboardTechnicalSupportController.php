<?php

namespace App\Http\Controllers\kios;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\kios\KiosRepository;

class DashboardTechnicalSupportController extends Controller
{
    public function __construct(private KiosRepository $suppKiosRepo){}

    public function index()
    {
        $user = auth()->user();
        $divisiName = $this->suppKiosRepo->getDivisi($user);

        return view('kios.technical_support.dashboard', [
            'title' => 'Dasboard TS',
            'active' => 'dashboard-ts',
            'navActive' => 'technical-support',
            'divisi' => $divisiName,
            'dropdown' => '',
            'dropdownShop' => '',
        ]);
    }

}
