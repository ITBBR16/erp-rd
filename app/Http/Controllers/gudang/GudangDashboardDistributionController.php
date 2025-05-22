<?php

namespace App\Http\Controllers\gudang;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\repair\RepairCase;
use App\Http\Controllers\Controller;
use App\Models\kios\KiosTransaksiPart;
use App\Models\repair\RepairEstimasiPart;
use App\Repositories\umum\UmumRepository;

class GudangDashboardDistributionController extends Controller
{
    public function __construct(
        private UmumRepository $umumRepository,
        private RepairEstimasiPart $estimasiPart,
        private RepairCase $repairCase,
        private KiosTransaksiPart $transaksiKiosPart,
    ){}

    public function index()
    {
        $user = auth()->user();
        $divisiName = $this->umumRepository->getDivisi($user);
        $listSudahDikirim = $this->listSudahDikirim();
        $listBelumDikirim = $this->listBelumDikirim();
        $listbelumlanjut = $this->listBelumLanjut();
        $listLakuKios = $this->lakuKios();
        $totalNewCase = $this->newCaseThisMonth();
        $totalCloseCase = $this->closedCasesThisMonth();

        return view('gudang.distribusi-produk.dashboard.index', [
            'title' => 'Dashboard Distribusi Produk',
            'active' => 'dashboard-distribusi-produk',
            'navActive' => 'distribusi',
            'divisi' => $divisiName,
            'listSudahDikirim' => $listSudahDikirim,
            'listBelumDikirim' => $listBelumDikirim,
            'listbelumlanjut' => $listbelumlanjut,
            'listLakuKios' => $listLakuKios,
            'totalNewCase' => $totalNewCase,
            'totalCloseCase' => $totalCloseCase,
        ]);
    }

    private function newCaseThisMonth()
    {
        $newCaseThisMonth = $this->repairCase
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();

        return $newCaseThisMonth;
    }

    private function closedCasesThisMonth()
    {
        $closedCasesThisMonth = $this->repairCase
            ->whereHas('jenisStatus', function ($query) {
                $query->where('jenis_status', 'Close Case (Done)');
            })
            ->whereMonth('updated_at', Carbon::now()->month)
            ->whereYear('updated_at', Carbon::now()->year)
            ->count();

        return $closedCasesThisMonth;
    }

    private function listSudahDikirim()
    {
        $listSudahDikirim = $this->estimasiPart
                ->whereNotNull('tanggal_dikirim')
                ->where('tanggal_dikirim', '!=', '')
                ->get()
                ->groupBy('gudang_produk_id')
                ->map(function ($items) {
                    return [
                        'jenis_drone' => $items->first()->sparepartGudang->produkSparepart->produkJenis->jenis_produk,
                        'nama_sparepart' => $items->first()->sparepartGudang->produkSparepart->nama_internal,
                        'modal_gudang' => $items->sum('modal_gudang'),
                        'total_quantity' => $items->count(),
                        'stock' => $items->first()->sparepartGudang->produkSparepart->gudangIdItem->where('status_inventory', 'Ready')->count()
                    ];
                })
                ->sortByDesc('total_quantity')
                ->values();

        return $listSudahDikirim;
    }

    private function listBelumDikirim()
    {
        $listBelumDikirim = $this->estimasiPart
            ->whereNull('tanggal_dikirim')
            ->orWhere('tanggal_dikirim', '')
            ->whereNotNull('tanggal_konfirmasi')
            ->where('tanggal_konfirmasi', '!=', '')
            ->get()
            ->groupBy('gudang_produk_id')
            ->map(function ($items) {
                return [
                    'jenis_drone' => $items->first()->sparepartGudang->produkSparepart->produkJenis->jenis_produk,
                    'nama_sparepart' => $items->first()->sparepartGudang->produkSparepart->nama_internal,
                    'modal_gudang' => $items->sum('modal_gudang'),
                    'total_quantity' => $items->count(),
                    'stock' => $items->first()->sparepartGudang->produkSparepart->gudangIdItem->where('status_inventory', 'Ready')->count()
                ];
            })
            ->sortByDesc('total_quantity')
            ->values();
        
        return $listBelumDikirim;
    }

    private function listBelumLanjut()
    {
        $listBelumLanjut = $this->estimasiPart
                ->whereNull('tanggal_konfirmasi')
                ->orWhere('tanggal_konfirmasi', '')
                ->get()
                ->groupBy('gudang_produk_id')
                ->map(function ($items) {
                    return [
                        'jenis_drone' => $items->first()->sparepartGudang->produkSparepart->produkJenis->jenis_produk,
                        'nama_sparepart' => $items->first()->sparepartGudang->produkSparepart->nama_internal,
                        'modal_gudang' => $items->sum('modal_gudang'),
                        'total_quantity' => $items->count(),
                        'stock' => $items->first()->sparepartGudang->produkSparepart->gudangIdItem->where('status_inventory', 'Ready')->count()
                    ];
                })
                ->sortByDesc('total_quantity')
                ->values();
            
        return $listBelumLanjut;
    }

    private function lakuKios()
    {
        $listTransaksiKios = $this->transaksiKiosPart
                ->get()
                ->groupBy('gudang_produk_id')
                ->map(function ($items) {
                    return [
                        'jenis_drone' => $items->first()->sparepart->produkJenis->jenis_produk,
                        'nama_sparepart' => $items->first()->sparepart->nama_internal,
                        'modal_gudang' => $items->sum('modal_gudang'),
                        'total_quantity' => $items->count(),
                        'stock' => $items->first()->sparepart->gudangIdItem->where('status_inventory', 'Ready')->count()
                    ];
                })
                ->sortByDesc('total_quantity')
                ->values();
        return $listTransaksiKios;
    }
}
