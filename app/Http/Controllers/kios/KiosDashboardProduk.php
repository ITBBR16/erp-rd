<?php

namespace App\Http\Controllers\kios;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\kios\KiosOrder;
use App\Models\kios\KiosProduk;
use App\Models\kios\KiosTransaksi;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\kios\KiosProdukSecond;
use App\Models\kios\KiosSerialNumber;
use App\Models\kios\KiosTransaksiDetail;
use App\Repositories\kios\KiosRepository;

class KiosDashboardProduk extends Controller
{
    public function __construct(private KiosRepository $suppKiosRepo) {}

    public function index()
    {
        $user = auth()->user();
        $divisiName = $this->suppKiosRepo->getDivisi($user);
        $totalSalesThisWeek = array_sum($this->thisWeekSales());
        $totalSalesLastWeek = array_sum($this->lastWeekSales());
        $totalModal = $this->getTotalModal();
        $totalPbaru = $this->getTotalProdukBaru();
        $totalPbekas = $this->getTotalProdukBekas();
        $listBelanja = $this->listBelanjaBulanIni();
        $produkPromo = $this->listProdukPromo();
        $listTransaksi = $this->listTransaksiBulanIni();
        $thisWeekSales = $this->thisWeekSales();
        $lastWeekSales = $this->lastWeekSales();
        $dataTransaksi = $this->dataTransaksiBulanIni();

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
            'listBelanja' => $listBelanja,
            'produkPromo' => $produkPromo,
            'listTransaksi' => $listTransaksi,
            'thisWeek' => $thisWeekSales,
            'lastWeek' => $lastWeekSales,
            'dataTransaksi' => $dataTransaksi,
        ]);
    }

    private function thisWeekSales()
    {
        $today = Carbon::now();
        $salesThisWeek = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = $today->copy()->subDays($i);
            $sales = KiosTransaksi::whereDate('updated_at', $date)
                ->where('status', 'Done')
                ->get()
                ->sum(function ($transaction) {
                    return $transaction->detailtransaksi->sum(function ($detail) {
                        $orderNilai = 0;
                        if (in_array($detail->jenis_transaksi, ['drone_baru', 'drone_bekas', 'drone_bnob'])) {
                            $orderNilai = match ($detail->jenis_transaksi) {
                                'drone_baru'  => $detail->kiosSerialnumbers->validasiproduk->orderLists->nilai ?? 0,
                                'drone_bekas' => $detail->produkKiosBekas->modal_bekas ?? 0,
                                'drone_bnob'  => $detail->produkKiosBnob->modal_bnob ?? 0,
                                default       => 0
                            };
                        }

                        return ($detail->harga_promo > 0 ? $detail->harga_promo : $detail->harga_jual)
                            - $orderNilai;
                    }) + $transaction->tax - $transaction->discount + $transaction->ongkir;
                });

            array_push($salesThisWeek, $sales);
        }

        return $salesThisWeek;
    }

    private function lastWeekSales()
    {
        $lastWeekStartDate = Carbon::now()->subWeek();
        $salesLastWeek = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = $lastWeekStartDate->copy()->subDays($i);
            $sales = KiosTransaksi::whereDate('updated_at', $date)
                ->where('status', 'Done')
                ->get()
                ->sum(function ($transaction) {
                    return $transaction->detailtransaksi->sum(function ($detail) {
                        $orderNilai = 0;
                        if (in_array($detail->jenis_transaksi, ['drone_baru', 'drone_bekas', 'drone_bnob'])) {
                            $orderNilai = match ($detail->jenis_transaksi) {
                                'drone_baru'  => $detail->kiosSerialnumbers->validasiproduk->orderLists->nilai ?? 0,
                                'drone_bekas' => $detail->produkKiosBekas->modal_bekas ?? 0,
                                'drone_bnob'  => $detail->produkKiosBnob->modal_bnob ?? 0,
                                default       => 0
                            };
                        }

                        return ($detail->harga_promo > 0 ? $detail->harga_promo : $detail->harga_jual)
                            - $orderNilai;
                    }) + $transaction->tax - $transaction->discount + $transaction->ongkir;
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

    private function listBelanjaBulanIni()
    {
        $thisYear = date('Y');
        $thisMonth = date('m');

        $listBelanjaBulanIni = KiosOrder::whereRaw('YEAR(order.created_at) = ? AND MONTH(order.created_at) = ?', [$thisYear, $thisMonth])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return $listBelanjaBulanIni;
    }

    private function listProdukPromo()
    {
        $produkPromo = KiosProduk::where('status', 'Promo')->get();
        return $produkPromo;
    }

    private function dataTransaksiBulanIni()
    {
        return KiosTransaksiDetail::select(
            DB::raw("REPLACE(jenis_transaksi, '_', ' ') as jenis_transaksi"),
            'produk_sub_jenis.paket_penjualan',
            DB::raw('COUNT(*) as total')
        )
            ->join('kios_produk', 'kios_transaksi_detail.kios_produk_id', '=', 'kios_produk.id')
            ->join('rumahdrone_produk.produk_sub_jenis as produk_sub_jenis', 'kios_produk.sub_jenis_id', '=', 'produk_sub_jenis.id')
            ->whereYear('kios_transaksi_detail.created_at', date('Y'))
            ->whereMonth('kios_transaksi_detail.created_at', date('m'))
            ->groupBy(DB::raw("REPLACE(jenis_transaksi, '_', ' ')"), 'produk_sub_jenis.paket_penjualan')
            ->orderByDesc('total')
            ->get();
    }

    private function listTransaksiBulanIni()
    {
        $thisYear = date('Y');
        $thisMonth = date('m');

        $listTransaksiBulanIni = KiosTransaksi::select('customer_id', 'kios_transaksi.id', 'kios_transaksi.created_at')
            ->selectRaw('SUM(kios_transaksi.total_harga + kios_transaksi.tax + kios_transaksi.ongkir - kios_transaksi.discount + COALESCE(dp.jumlah_pembayaran, 0)) as total_transaksi')
            ->leftJoin('kios_transaksi_dp as dp', 'dp.kios_transaksi_id', '=', 'kios_transaksi.id')
            ->whereRaw('YEAR(kios_transaksi.updated_at) = ? AND MONTH(kios_transaksi.updated_at) = ?', [$thisYear, $thisMonth])
            ->where(function ($query) {
                $query->where('kios_transaksi.status_dp', null)
                    ->orWhere('kios_transaksi.status_dp', 'Lunas');
            })
            ->where(function ($query) {
                $query->where('kios_transaksi.status_po', null)
                    ->orWhere('kios_transaksi.status_po', 'Lunas');
            })
            ->groupBy('kios_transaksi.id', 'kios_transaksi.customer_id', 'kios_transaksi.created_at')
            ->orderByDesc('total_transaksi')
            ->limit(5)
            ->get();

        return $listTransaksiBulanIni;
    }
}
