<?php

namespace App\Http\Controllers\kios;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use App\Models\customer\Customer;
use App\Models\kios\KiosTransaksiDetail;
use App\Repositories\kios\KiosRepository;

class DashboardKiosController extends Controller
{
    public function __construct(private KiosRepository $suppKiosRepo){}

    public function index()
    {
        $user = auth()->user();
        $divisiName = $this->suppKiosRepo->getDivisi($user);
        $startDate = Carbon::now()->subDays(30);
        $endDate = Carbon::now();
        $endDatePrevious = $startDate->copy()->subDay();
        $startDatePrevious = $endDatePrevious->copy()->subDays(30);

        // Count Profit
        $transaksiTerbaru = KiosTransaksiDetail::with('serialnumbers.validasiproduk.orderLists')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->get();
            
        $transaksiCompare = KiosTransaksiDetail::with('serialnumbers.validasiproduk.orderLists')
            ->whereBetween('created_at', [$startDatePrevious, $endDatePrevious])
            ->get();

        $totalModal = 0;
        $totalPenjualan = 0;

        foreach ($transaksiTerbaru as $detail) {
            $totalModal += $detail->serialnumbers->validasiproduk->orderLists->nilai;
            $totalPenjualan += $detail->harga_jual;
        }

        $totalProfit = $totalPenjualan - $totalModal;

        if ($totalProfit >= 0) {
            $profitType = 'Keuntungan';
        } elseif ($totalProfit < 0) {
            $profitType = 'Kerugian';
        }

        if ($totalPenjualan > 0) {
            $profitPercentage = round(($totalProfit / $totalPenjualan) * 100, 2);
        } else {
            $profitPercentage = 0;
        }

        // Drone Terjual
        $droneLaku = $transaksiTerbaru->count();

        // Count Customer Growth
        $newCustomer = Customer::whereBetween('created_at', [$startDate, $endDate])->count();
        $initialCustomer = Customer::where('created_at', '<', $startDate)->count();

        if($newCustomer >= $initialCustomer) {
            $typeGrowth = 'Bertambah';
        } else {
            $typeGrowth = 'Berkurang';
        }

        if ($initialCustomer > 0) {
            $growthPercentage = round(($newCustomer / $initialCustomer) * 100, 2);
        } else {
            $growthPercentage = 0;
        }

        return view('kios.main.index', [
            'title' => 'Dashboard Analisa',
            'active' => 'dashboard-kios',
            'navActive' => 'analisa',
            'dropdown' => '',
            'dropdownShop' => '',
            'divisi' => $divisiName,
            'totalProfit' => $totalProfit,
            'percentage' => $profitPercentage,
            'profitType' => $profitType,
            'customerPercentage' => $growthPercentage,
            'newCustomer' => $newCustomer,
            'typeGrowth' => $typeGrowth,
            'droneLaku' => $droneLaku,
        ]);
    }
}
