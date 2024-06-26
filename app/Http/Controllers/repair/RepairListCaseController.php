<?php

namespace App\Http\Controllers\repair;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\umum\UmumRepository;
use App\Models\customer\CustomerInfoPerusahaan;
use App\Repositories\repair\repository\RepairCustomerRepository;

class RepairListCaseController extends Controller
{
    public function __construct(private UmumRepository $nameDivisi, private RepairCustomerRepository $repairCustomer){}

    public function index()
    {
        $user = auth()->user();
        $divisiName = $this->nameDivisi->getDivisi($user);
        $dataProvinsi = $this->repairCustomer->getProvinsi();
        $infoPerusahaan = CustomerInfoPerusahaan::all();

        return view('repair.customer.case-list', [
            'title' => 'Case List',
            'active' => 'list-case',
            'navActive' => 'customer',
            'divisi' => $divisiName,
            'dataProvinsi' => $dataProvinsi,
            'infoPerusahaan' => $infoPerusahaan,
        ]);

    }

}
