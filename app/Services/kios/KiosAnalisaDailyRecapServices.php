<?php

namespace App\Services\kios;

use App\Repositories\umum\UmumRepository;

class KiosAnalisaDailyRecapServices
{
    public function __construct(
        private UmumRepository $umum
    ){}

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
}