<?php

namespace App\Http\Controllers\customer;

use Illuminate\Http\Request;
use App\Models\divisi\Divisi;
use Illuminate\Validation\Rule;
use App\Models\wilayah\Provinsi;
use App\Models\customer\Customer;
use App\Http\Controllers\Controller;
use App\Repositories\customer\CustomerRepository;
use Illuminate\Support\Facades\Http;

class DashboardCustomerController extends Controller
{

    public function index() 
    {
        return view('customer.main.index', [
            'title' => 'Dashboard Customer',
            'active' => 'dashboard-customer',
        ]);
    }

}
