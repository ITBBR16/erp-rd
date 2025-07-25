<?php

namespace App\Services\repair;

use Carbon\Carbon;
use App\Models\repair\RepairCase;
use App\Models\repair\RepairEstimasiPart;
use App\Repositories\umum\UmumRepository;

class RepairDashboardEstimasiServices
{
    public function __construct(
        private UmumRepository $umumRepository,
        private RepairEstimasiPart $estimasiPart,
        private RepairCase $repairCase,
    ) {}

    public function index()
    {
        $user = auth()->user();
        $divisiName = $this->umumRepository->getDivisi($user);
        $listSudahDikirim = $this->listSudahDikirim();
        $listBelumDikirim = $this->listBelumDikirim();
        $listbelumlanjut = $this->listBelumLanjut();
        $totalNewCase = $this->newCaseThisMonth();
        $totalCloseCase = $this->closedCasesThisMonth();
        $totalEstimasi = $this->countCaseEstimasi();

        return view('repair.estimasi.dashboard.index', [
            'title' => 'Dashboard Estimasi',
            'active' => 'dashboard-estimasi',
            'navActive' => 'estimasi',
            'dropdown' => '',
            'divisi' => $divisiName,
            'listSudahDikirim' => $listSudahDikirim,
            'listBelumDikirim' => $listBelumDikirim,
            'listbelumlanjut' => $listbelumlanjut,
            'totalNewCase' => $totalNewCase,
            'totalCloseCase' => $totalCloseCase,
            'totalEstimasi' => $totalEstimasi,
        ]);
    }

    private function countCaseEstimasi()
    {
        $countEstimasi = $this->repairCase
            ->whereHas('jenisStatus', function ($query) {
                $query->where('jenis_status', 'Proses Estimasi Biaya');
            })
            ->count();
        return $countEstimasi;
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
                ];
            })
            ->sortByDesc('total_quantity')
            ->values();

        return $listBelumLanjut;
    }
}
