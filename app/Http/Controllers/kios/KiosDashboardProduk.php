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
        $totalSalesThisWeek = array_sum($this->thisWeekSales());
        $totalSalesLastWeek = array_sum($this->lastWeekSales());

        $percentSales = ($totalSalesLastWeek != 0) ? (($totalSalesThisWeek - $totalSalesLastWeek) / $totalSalesLastWeek) * 100 : 0;

        return view('kios.product.dashboard', [
            'title' => 'Dashboard Produk',
            'active' => 'dashboard-produk',
            'navActive' => 'product',
            'dropdown' => '',
            'dropdownShop' => '',
            'divisi' => $divisiName,
            'totalSales' => $totalSalesThisWeek,
            'percentSales' => $percentSales,
        ]);
    }

    public function getWeeklySalesData()
    {
        $thisWeekSales = $this->thisWeekSales();
        $lastWeekSales = $this->lastWeekSales();

        return response()->json([
            'this_week' => $thisWeekSales,
            'last_week' => $lastWeekSales
        ]);
    }

    private function thisWeekSales()
    {
        $today = Carbon::now()->startOfWeek();
        $salesThisWeek = [];

        for ($i = 0; $i < 7; $i++) {
            $date = $today->copy()->addDays($i);
            $sales = KiosTransaksi::whereDate('created_at', $date)->sum('total_harga');
            array_push($salesThisWeek, $sales);
        }

        return $salesThisWeek;
    }

    private function lastWeekSales()
    {
        $today = Carbon::now()->subWeek()->startOfWeek();
        $salesLastWeek = [];

        for ($i = 0; $i < 7; $i++) {
            $date = $today->copy()->addDays($i);
            $sales = KiosTransaksi::whereDate('created_at', $date)->sum('total_harga');
            array_push($salesLastWeek, $sales);
        }

        return $salesLastWeek;
    }

}
