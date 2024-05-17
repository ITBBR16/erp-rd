<?php

namespace App\Http\Controllers\customer;

use App\Models\divisi\Divisi;
use App\Http\Controllers\Controller;

;

class DashboardCustomerController extends Controller
{
    public function index() 
    {
        $user = auth()->user();

        try {
    
            $divisiId = $user->divisi_id;
            if($divisiId != 0){
                $divisiName = Divisi::find($divisiId);
            } else {
                $divisiName = 'Super Admin';
            }
    
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
