<?php

namespace App\Services\kios;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\KiosDailyRecapExport;
use App\Repositories\umum\UmumRepository;

class KiosAnalisaDailyRecapServices
{
    public function __construct(
        private UmumRepository $umum
    ) {}

    public function index()
    {
        $user = auth()->user();
        $divisiName = $this->umum->getDivisi($user);

        return view('kios.analisa.daily-recap.analisa-dr', [
            'title' => 'Analisa Daily Recap',
            'active' => 'analisa-daily-recap',
            'navActive' => 'analisa',
            'divisi' => $divisiName,
        ]);
    }

    public function exportDailyRecap(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $timestamp = Carbon::now()->format('d M Y');

        return Excel::download(
            new KiosDailyRecapExport($request->start_date, $request->end_date),
            "Data Daily Recap - {$timestamp}.csv"
        );
    }
}
