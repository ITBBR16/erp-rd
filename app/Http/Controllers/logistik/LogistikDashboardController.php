<?php

namespace App\Http\Controllers\logistik;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\umum\UmumRepository;

class LogistikDashboardController extends Controller
{
    public function __construct(private UmumRepository $umumRepo){}

    public function index()
    {
        $user = auth()->user();
        $divisiName = $this->umumRepo->getDivisi($user);

        return view('logistik.index', [
            'title' => 'Dashboard Logistik',
            'active' => 'dashboard-logistik',
            'divisi' => $divisiName,
        ]);
    }
}
