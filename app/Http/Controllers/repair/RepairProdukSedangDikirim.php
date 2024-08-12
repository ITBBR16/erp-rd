<?php

namespace App\Http\Controllers\repair;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\umum\UmumRepository;
use App\Repositories\repair\repository\RepairCustomerRepository;

class RepairProdukSedangDikirim extends Controller
{
    public function __construct(private UmumRepository $nameDivisi, private RepairCustomerRepository $repairCustomer){}

    public function index()
    {
        $user = auth()->user();
        $divisiName = $this->nameDivisi->getDivisi($user);

        return view('repair.customer.produk-sedang-dikirim', [
            'title' => 'Produk Sedang Dikirim',
            'active' => 'p-dikirim',
            'navActive' => 'customer',
            'divisi' => $divisiName,
        ]);

    }

}
