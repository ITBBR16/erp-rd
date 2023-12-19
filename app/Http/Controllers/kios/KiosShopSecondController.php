<?php

namespace App\Http\Controllers\kios;

use Illuminate\Http\Request;
use App\Models\kios\KiosOrder;
use App\Http\Controllers\Controller;
use App\Repositories\kios\KiosRepository;

class KiosShopSecondController extends Controller
{
    public function __construct(private KiosRepository $suppKiosRepo){}

    public function index()
    {
        $user = auth()->user();
        $divisiName = $this->suppKiosRepo->getDivisi($user);
        $orders = KiosOrder::with('orderLists', 'supplier')->get();

        foreach ($orders as $order) {
            $totalNominal = $order->orderLists->sum('nilai');
            $data[] = [
                'orderId' => $order->id,
                'invoice' => $order->invoice,
                'status' => $order->status,
                'supplier_kios' => $order->supplier->nama_perusahaan,
                'totalNilai' => $totalNominal,
            ];
        }

        return view('kios.shop.index-second', [
            'title' => 'Shop Second',
            'active' => 'shop-second',
            'divisi' => $divisiName,
            'dropdown' => '',
            'dropdownShop' => true,
            'data' => $data,
        ]);
    }

    public function store(Request $request)
    {
        
    }
}
