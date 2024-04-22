<?php

namespace App\Http\Controllers\kios;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\kios\KiosTransaksi;
use App\Repositories\kios\KiosRepository;
use Carbon\Carbon;

class KiosDashboardProduk extends Controller
{
    public function __construct(private KiosRepository $suppKiosRepo){}

    public function index()
    {
        $user = auth()->user();
        $divisiName = $this->suppKiosRepo->getDivisi($user);

        return view('kios.product.dashboard', [
            'title' => 'Dashboard Produk',
            'active' => 'dashboard-produk',
            'navActive' => 'product',
            'dropdown' => '',
            'dropdownShop' => '',
            'divisi' => $divisiName,
        ]);
    }

    public function thisWeekSales()
    {
        $today = Carbon::now()->startOfWeek();
        $salesThisWeek = [];

        for ($i = 0; $i < 7; $i++) {
            $date = $today->copy()->addDays($i);
            $sales = KiosTransaksi::whereDate('created_at', $date)->sum('total_harga');
            array_push($salesThisWeek, $sales);
        }

        return response()->json($salesThisWeek);
    }

    public function lastWeekSales()
    {
        $today = Carbon::now()->startOfWeek();
        $salesLastweek = [];

        for ($i = 0; $i < 7; $i++) {
            $date = $today->copy()->addDays($i);
            $sales = KiosTransaksi::whereDate('created_at', $date)->sum('total_harga');
            array_push($salesLastweek, $sales);
        }

        return response()->json($salesLastweek);
    }

}
