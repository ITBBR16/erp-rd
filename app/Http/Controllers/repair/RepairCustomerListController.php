<?php

namespace App\Http\Controllers\repair;

use Illuminate\Http\Request;
use App\Models\customer\Customer;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Repositories\umum\UmumRepository;
use App\Repositories\repair\repository\RepairCustomerRepository;
use Exception;

class RepairCustomerListController extends Controller
{
    public function __construct(
        private UmumRepository $umum,
        private RepairCustomerRepository $repairCustomer){}

    public function index()
    {
        $user = auth()->user();
        $divisiName = $this->umum->getDivisi($user);
        $dataCustomer = $this->repairCustomer->getAll();
        $provinsi = $this->repairCustomer->getProvinsi();

        return view('repair.customer.list-customer', [
            'title' => 'Customer List',
            'active' => 'list-customer',
            'navActive' => 'customer',
            'divisi' => $divisiName,
            'dataCustomer' => $dataCustomer,
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

        return response()->json(['data' => $dataCustomer]);
    }


}
