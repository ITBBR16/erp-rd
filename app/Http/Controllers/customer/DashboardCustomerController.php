<?php

namespace App\Http\Controllers\customer;

use App\Http\Controllers\Controller;
use App\Repositories\kios\KiosRepository;

;

class DashboardCustomerController extends Controller
{
    public function __construct(private KiosRepository $reppo){}

    public function index() 
    {
        $user = auth()->user();
        $divisiName = $this->reppo->getDivisi($user);
        
        return view('customer.main.index', [
            'title' => 'Dashboard Customer',
            'active' => 'dashboard-customer',
            'divisi' => $divisiName,
        ]);

    }

}
