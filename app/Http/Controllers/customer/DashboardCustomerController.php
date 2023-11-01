<?php

namespace App\Http\Controllers\customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardCustomerController extends Controller
{
    public function index() {
        return view('customer.main.index', [
            'title' => 'Dashboard Customer',
            'active' => 'dashboard-customer'
        ]);
    }
}
