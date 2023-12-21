<?php

namespace App\Http\Controllers\kios;

use App\Http\Controllers\Controller;
use App\Models\kios\KiosPayment;
use App\Repositories\kios\KiosRepository;

class KiosPaymentController extends Controller
{
    public function __construct(private KiosRepository $suppKiosRepo){}

    public function index()
    {
        $user = auth()->user();
        $divisiName = $this->suppKiosRepo->getDivisi($user);
        $payment = KiosPayment::with('order')->get();

        return view('kios.shop.payment.payment', [
            'title' => 'Payment',
            'active' => 'payment',
            'dropdown' => '',
            'dropdownShop' => '',
            'divisi' => $divisiName,
            'payment' => $payment,
        ]);
    }
}
