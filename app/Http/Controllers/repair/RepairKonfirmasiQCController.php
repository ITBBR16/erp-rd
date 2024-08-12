<?php

namespace App\Http\Controllers\repair;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\umum\UmumRepository;

class RepairKonfirmasiQCController extends Controller
{
    public function __construct(private UmumRepository $nameDivisi){}

    public function index()
    {
        $user = auth()->user();
        $divisiName = $this->nameDivisi->getDivisi($user);

        return view('repair.csr.konfirmasi-qc', [
            'title' => 'Konfirmasi QC',
            'active' => 'konf-qc',
            'navActive' => 'csr',
            'divisi' => $divisiName,
        ]);

    }

}
