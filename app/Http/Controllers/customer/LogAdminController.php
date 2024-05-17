<?php

namespace App\Http\Controllers\customer;

use App\Http\Controllers\Controller;
use App\Models\customer\LogAdmin;
use Illuminate\Http\Request;

class LogAdminController extends Controller
{
    public function index() 
    {
        $logData = LogAdmin::all();

        return view('customer.main.adminLog', [
            'title' => 'Log',
            'active' => 'log-admin',
            'logData' => $logData
        ]);
    }
}
