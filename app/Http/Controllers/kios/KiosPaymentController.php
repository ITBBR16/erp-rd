<?php

namespace App\Http\Controllers\kios;

use App\Http\Controllers\Controller;
use App\Repositories\kios\KiosRepository;

class KiosPaymentController extends Controller
{
    public function __construct(private KiosRepository $suppKiosRepo){}

    public function index()
    {
        $user = auth()->user();
        $divisiName = $this->suppKiosRepo->getDivisi($user);

        return view('kios.shop.payment.payment', [
            'title' => 'Payment',
            'active' => 'payment',
            'dropdown' => '',
            'dropdownShop' => '',
            'divisi' => $divisiName,
        ]);
    }
}
