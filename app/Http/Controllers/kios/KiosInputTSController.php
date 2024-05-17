<?php

namespace App\Http\Controllers\kios;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\kios\KiosRepository;

class KiosInputTSController extends Controller
{
    public function __construct(private KiosRepository $suppKiosRepo){}

    public function index()
    {
        $user = auth()->user();
        $divisiName = $this->suppKiosRepo->getDivisi($user);

        return view('kios.technical_support.input-technical-support', [
            'title' => 'Input TS',
            'active' => 'input-ts',
            'navActive' => 'technical-support',
            'divisi' => $divisiName,
            'dropdown' => '',
            'dropdownShop' => '',
        ]);
    }

}
