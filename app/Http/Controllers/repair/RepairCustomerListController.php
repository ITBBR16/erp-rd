<?php

namespace App\Http\Controllers\repair;

use Illuminate\Http\Request;
use App\Models\wilayah\Provinsi;
use App\Models\customer\Customer;
use App\Http\Controllers\Controller;
use App\Repositories\umum\UmumRepository;
use App\Repositories\customer\CustomerRepository;

class RepairCustomerListController extends Controller
{
    public function __construct(private UmumRepository $nameDivisi, private CustomerRepository $customerRepo){}

    public function index()
    {
        $user = auth()->user();
        $divisiName = $this->nameDivisi->getDivisi($user);
        $dataCustomer = $this->customerRepo->getAll();
        $dataKota = $this->customerRepo->getSelectKota();
        $dataKecamatan = $this->customerRepo->getSelectKecamatan();
        $dataKelurahan = $this->customerRepo->getSelectKelurahan();
        $provinsi = Provinsi::all();

        return view('repair.customer.list-customer', [
            'title' => 'Customer List',
            'active' => 'list-customer',
            'navActive' => 'customer',
            'dropdown' => '',
            'dropdownShop' => '',
            'divisi' => $divisiName,
            'dataCustomer' => $dataCustomer,
            'dataKota' => $dataKota,
            'dataKecamatan' => $dataKecamatan,
            'dataKelurahan' => $dataKelurahan,
            'provinsi' => $provinsi,
        ]);

    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $dataCustomer = Customer::where(function($q) use ($query) {
                            $q->where('first_name', 'like', "%$query%")
                            ->orWhere('last_name', 'like', "%$query%")
                            ->orWhereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%$query%"]);
                        })
                        ->orWhere('no_telpon', 'like', "%$query%")
                        ->get();

        return response()->json($dataCustomer);
    }


}
