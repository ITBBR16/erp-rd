<?php

namespace App\Http\Controllers\kios;

use Illuminate\Http\Request;
use App\Models\divisi\Divisi;
use App\Http\Controllers\Controller;

class KiosSupplierController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $divisiId = $user->divisi_id;
        if($divisiId != 0){
            $divisiName = Divisi::find($divisiId);
        } else {
            $divisiName = 'Super Admin';
        }

        return view('kios.supplier.supplier', [
            'title' => 'Supplier',
            'active' => 'supplier',
            'divisi' => $divisiName,
        ]);
    }
}
