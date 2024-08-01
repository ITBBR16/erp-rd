<?php

namespace App\Http\Controllers\kios;

use Carbon\Carbon;
use App\Models\customer\Customer;
use App\Models\kios\KiosTransaksi;
use App\Http\Controllers\Controller;
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

        // Count Profit
        $profitThisMonth = array_sum($this->thisMonthSales());
        $profitPeriodeSebelumnya = array_sum($this->periodeSebelumnya());
        $totalProfit = $profitThisMonth - $profitPeriodeSebelumnya;
        $profitType = ($totalProfit >= 0) ? 'Keuntungan' : 'Kerugian';
        $profitPercentage = ($totalProfit > 0) ? ($totalProfit / max(1, $profitPeriodeSebelumnya)) * 100 : 0;
        $profitPercentage = min($profitPercentage, 100);
        $formattedPercentSales = number_format($profitPercentage, 2);

        // Drone Terjual
        $transaksiTerbaru = KiosTransaksiDetail::with('kiosSerialnumbers.validasiproduk.orderLists')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->get();
        $droneLaku = $transaksiTerbaru->count();

        // Count Customer Growth
        $newCustomer = Customer::whereBetween('created_at', [$startDate, $endDate])->count();
        $initialCustomer = Customer::where('created_at', '<', $startDate)->count();
        $typeGrowth = ($newCustomer >= $initialCustomer) ? 'Bertambah' : 'Berkurang';
        $growthPercentage = ($initialCustomer > 0) ? (($newCustomer - $initialCustomer) / $initialCustomer) * 100 : 0;

        return view('kios.main.index', [
            'title' => 'Dashboard Analisa',
            'active' => 'dashboard-kios',
            'navActive' => 'analisa',
            'dropdown' => '',
            'dropdownShop' => '',
            'divisi' => $divisiName,
            'totalProfit' => $totalProfit,
            'percentage' => $formattedPercentSales,
            'profitType' => $profitType,
            'customerPercentage' => $growthPercentage,
            'newCustomer' => $newCustomer,
            'typeGrowth' => $typeGrowth,
            'droneLaku' => $droneLaku,
        ]);
    }

    public function analisaChart()
    {
        $bulanIni = $this->thisMonthSales();
        $periodeSebelumnya = $this->periodeSebelumnya();

        return response()->json([
            'bulan_ini' => $bulanIni,
            'periode_sebelumnya' => $periodeSebelumnya
        ]);
    }

    private function thisMonthSales()
    {
        $today = Carbon::now();
        $salesThisMonth = [];

        $daysInMonth = $today->daysInMonth;

        for ($i = 1; $i <= $daysInMonth; $i++) {
            $date = $today->copy()->startOfMonth()->addDays($i - 1);
            $sales = KiosTransaksi::whereDate('created_at', $date)
                ->where(function ($query) {
                    $query->where('status_dp', '')
                        ->orWhere('status_dp', 'Lunas');
                })
                ->where(function ($query) {
                    $query->where('status_po', '')
                        ->orWhere('status_po', 'Lunas');
                })
                ->get()
                ->sum(function ($transaction) {
                    return $transaction->detailtransaksi->sum(function ($detail) {
                        return ($detail->harga_promo > 0 ? $detail->harga_promo : $detail->harga_jual) - $detail->serialnumbers->validasiproduk->orderLists->nilai;
                    }) + $transaction->tax - $transaction->discount;
                });

            array_push($salesThisMonth, $sales);
        }

        return $salesThisMonth;
    }

    private function periodeSebelumnya()
    {
        $today = Carbon::now();
        $lastYear = $today->copy()->subYear();
        $salesLastYearThisMonth = [];

        $daysInMonth = $lastYear->daysInMonth;

        for ($i = 1; $i <= $daysInMonth; $i++) {
            $date = $lastYear->copy()->startOfMonth()->addDays($i - 1);
            $sales = KiosTransaksi::whereDate('created_at', $date)
                ->where(function ($query) {
                    $query->where('status_dp', '')
                        ->orWhere('status_dp', 'Lunas');
                })
                ->where(function ($query) {
                    $query->where('status_po', '')
                        ->orWhere('status_po', 'Lunas');
                })
                ->get()
                ->sum(function ($transaction) {
                    return $transaction->detailtransaksi->sum(function ($detail) {
                        return ($detail->harga_promo > 0 ? $detail->harga_promo : $detail->harga_jual) - $detail->serialnumbers->validasiproduk->orderLists->nilai;
                    }) + $transaction->tax - $transaction->discount;
                });

            array_push($salesLastYearThisMonth, $sales);
        }

        return $salesLastYearThisMonth;
    }

}
