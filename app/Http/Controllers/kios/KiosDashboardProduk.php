<?php

namespace App\Http\Controllers\kios;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\kios\KiosProdukSecond;
use App\Models\kios\KiosSerialNumber;
use App\Models\kios\KiosTransaksi;
use App\Models\kios\KiosTransaksiDetail;
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
        $totalModal = $this->getTotalModal();
        $totalPbaru = $this->getTotalProdukBaru();
        $totalPbekas = $this->getTotalProdukBekas();
        $topProduct = $this->topProductThisMonth();
        $topCustomer = $this->topCustomerThisMonth();

        $percentSales = ($totalSalesLastWeek != 0) ? (($totalSalesThisWeek - $totalSalesLastWeek) / $totalSalesLastWeek) * 100 : 0;
        $formattedPercentSales = number_format($percentSales, 2);

        return view('kios.product.dashboard', [
            'title' => 'Dashboard Produk',
            'active' => 'dashboard-produk',
            'navActive' => 'product',
            'dropdown' => '',
            'dropdownShop' => '',
            'divisi' => $divisiName,
            'totalSales' => $totalSalesThisWeek,
            'percentSales' => $formattedPercentSales,
            'totalmodal' => $totalModal,
            'totalpbaru' => $totalPbaru,
            'totalpbekas' => $totalPbekas,
            'topproduct' => $topProduct,
            'topcustomer' => $topCustomer,
        ]);
    }

    public function getWeeklySalesData()
    {
        $thisWeekSales = $this->thisWeekSales();
        $lastWeekSales = $this->lastWeekSales();

        return response()->json([
            'this_week' => $thisWeekSales,
            'last_week' => $lastWeekSales,
        ]);
    }

    private function thisWeekSales()
    {
        $today = Carbon::now();
        $salesThisWeek = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = $today->copy()->subDays($i);
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

            array_push($salesThisWeek, $sales);
        }

        return $salesThisWeek;
    }
    private function lastWeekSales()
    {
        $lastWeekStartDate = Carbon::now()->subWeek();;
        $salesLastWeek = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = $lastWeekStartDate->copy()->subDays($i);
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
            array_push($salesLastWeek, $sales);
        }

        return $salesLastWeek;
    }

    private function getTotalModal()
    {
        $totalModal = KiosSerialNumber::where('status', 'Ready')
                      ->get()
                      ->sum(function ($total) {
                            return $total->validasiproduk->orderLists->nilai;
                      });

        return $totalModal;
    }

    private function getTotalProdukBaru()
    {
        $totalProdukBaru = KiosSerialNumber::where('status', 'Ready')->count();
        return $totalProdukBaru;
    }

    private function getTotalProdukBekas()
    {
        $totalProdukBekas = KiosProdukSecond::where('status', 'Ready')->count();
        return $totalProdukBekas;
    }

    private function topProductThisMonth()
    {
        $thisYear = date('Y');
        $thisMonth = date('m');

        $topProducts = KiosTransaksiDetail::select('kios_produk_id')
                        ->selectRaw('COUNT(*) as total_penjualan')
                        ->whereRaw('YEAR(created_at) = ? AND MONTH(created_at) = ?', [$thisYear, $thisMonth])
                        ->whereNotNull('serial_number_id')
                        ->groupBy('kios_produk_id')
                        ->orderByDesc('total_penjualan')
                        ->limit(5)
                        ->get();

        return $topProducts;
    }

    private function topCustomerThisMonth()
    {
        $thisYear = date('Y');
        $thisMonth = date('m');

        $topCustomer = KiosTransaksi::select('customer_id')
                       ->selectRaw('SUM(total_harga + tax - discount) as total_transaksi')
                       ->whereRaw('YEAR(created_at) = ? AND MONTH(created_at) = ?', [$thisYear, $thisMonth])
                       ->where(function ($query) {
                            $query->where('status_dp', '')
                                ->orWhere('status_dp', 'Lunas');
                        })
                        ->where(function ($query) {
                            $query->where('status_po', '')
                                ->orWhere('status_po', 'Lunas');
                        })
                       ->groupBy('customer_id')
                       ->orderByDesc('total_transaksi')
                       ->limit(5)
                       ->get();

        return $topCustomer;
    }

}
