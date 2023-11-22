<?php

namespace App\Http\Controllers\customer;

use App\Models\divisi\Divisi;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use Clockwork\Request\Request;

;

class DashboardCustomerController extends Controller
{
    public function index() 
    {
        $user = auth()->user();

        try {
    
            $divisiId = $user->divisi_id;
            $divisiName = Divisi::find($divisiId);
    
            return view('customer.main.index', [
                'title' => 'Dashboard Customer',
                'active' => 'dashboard-customer',
                'divisi' => $divisiName,
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with('loginError', 'Failed to authenticate user: ' . $e->getMessage());
        }
    }

}
