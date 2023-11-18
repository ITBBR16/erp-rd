<?php

namespace App\Http\Controllers\kios;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardKiosController extends Controller
{
    public function index()
    {
        return view('kios.main.index', [
            'title' => 'Kios',
            'active' => 'dashboard-kios'
        ]);
    }
}
