<?php

namespace App\Http\Controllers\customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LogAdminController extends Controller
{
    public function index() {
        return view('customer.main.adminLog', [
            'title' => 'Log',
            'active' => 'log-admin'
        ]);
    }
}
