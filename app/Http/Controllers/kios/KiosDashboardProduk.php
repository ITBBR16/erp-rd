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
        $today = Carbon::now();
        $salesThisWeek = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = $today->copy()->subDays($i);
            $sales = KiosTransaksi::whereDate('created_at', $date)
                ->get()
                ->sum(function ($transaction) {
                    return $transaction->detailtransaksi->sum(function ($detail) {
                        return ($detail->harga_promo > 0 ? $detail->harga_promo : $detail->harga_jual) - $detail->serialnumbers->validasiproduk->orderLists->nilai;
                    }) + $transaction->tax - $transaction->discount;
                });

            array_push($salesThisWeek, $sales);
        }

        return $salesThisWeek;
    }

    private function lastWeekSales()
    {
        $lastWeekStartDate = Carbon::now()->subWeek()->startOfWeek();
        $lastWeekEndDate = Carbon::now()->subWeek()->endOfWeek();
        $salesLastWeek = [];

        for ($i = 13; $i >= 7; $i--) {
            $date = $lastWeekStartDate->copy()->addDays($i - 7);
            $sales = KiosTransaksi::whereBetween('created_at', [$date, $lastWeekEndDate])
                ->get()
                ->sum(function ($transaction) {
                    return $transaction->detailtransaksi->sum(function ($detail) {
                        return ($detail->harga_promo > 0 ? $detail->harga_promo : $detail->harga_jual) - $detail->serialnumbers->validasiproduk->orderLists->nilai;
                    }) + $transaction->tax - $transaction->discount;
                });
            array_push($salesLastWeek, $sales);
        }

        return $salesLastWeek;
    }

}
