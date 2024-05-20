<?php

namespace App\Http\Controllers\kios;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\kios\KiosAkunRD;
use App\Models\customer\Customer;
use App\Models\kios\KiosTransaksi;
use App\Http\Controllers\Controller;
use App\Repositories\kios\KiosRepository;

class KiosPODPController extends Controller
{
    public function __construct(private KiosRepository $suppKiosRepo){}

    public function index()
    {
        $user = auth()->user();
        $divisiName = $this->suppKiosRepo->getDivisi($user);
        $today = Carbon::now();
        $dueDate = $today->copy()->addMonth(3);
        $customerData = Customer::all();
        $akunRd = KiosAkunRD::all();
        $invoiceId = KiosTransaksi::latest()->value('id');

        return view('kios.kasir.dppo', [
            'title' => 'DP / PO Kios',
            'active' => 'dp-po-kios',
            'navActive' => 'kasir',
            'divisi' => $divisiName,
            'dropdown' => '',
            'dropdownShop' => '',
            'today' => $today,
            'duedate' => $dueDate,
            'customerdata' => $customerData,
            'akunrd' => $akunRd,
            'invoiceid' => $invoiceId,
        ]);
    }

}
