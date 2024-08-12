<?php

namespace App\Http\Controllers\repair;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\umum\UmumRepository;
use App\Repositories\repair\repository\RepairCustomerRepository;

class KasirRepairController extends Controller
{
    public function __construct(private UmumRepository $nameDivisi, private RepairCustomerRepository $repairCustomer){}

    public function index()
    {
        $user = auth()->user();
        $divisiName = $this->nameDivisi->getDivisi($user);
        $dataProvinsi = $this->repairCustomer->getProvinsi();

        return view('repair.csr.kasir-repair', [
            'title' => 'Kasir Repair',
            'active' => 'kasir-repair',
            'navActive' => 'csr',
            'divisi' => $divisiName,
            'dataProvinsi' => $dataProvinsi,
        ]);

    }

    public function edit()
    {
        $user = auth()->user();
        $divisiName = $this->nameDivisi->getDivisi($user);
        $dataProvinsi = $this->repairCustomer->getProvinsi();

        return view('repair.csr.edit.kasir-pelunasan', [
            'title' => 'Kasir Repair',
            'active' => 'kasir-repair',
            'navActive' => 'csr',
            'divisi' => $divisiName,
            'dataProvinsi' => $dataProvinsi,
        ]);
    }

}
