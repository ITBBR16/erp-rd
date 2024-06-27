<?php

namespace App\Http\Controllers\repair;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
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

    public function store(Request $request)
    {
        $connectionCustomer = DB::connection('rumahdrone_customer');
        $connectionCustomer->beginTransaction();

        try {
            $divisiId = auth()->user()->divisi_id;

            $validate = $request->validate([
                'first_name' => 'required',
                'lats_name' => 'required',
                'asal_informasi' => 'required',
                'no_telpon' => ['required' , 'regex:/^62\d{9,}$/', Rule::unique('rumahdrone_customer.customer', 'no_telpon')],
                'email' => 'required|email:dns',
                'instansi' => 'max:255',
                'provinsi' => 'required',
                'nama_jalan' => 'required',
            ]);

            $validate['by_divisi'] = $divisiId;
            $this->repairCustomer->createCustomer($validate);

            $connectionCustomer->commit();
            return back()->with('success', 'Success Save New Contact!');
        } catch(Exception $e){
            $connectionCustomer->rollBack();
            return back()->with('error', $e->getMessage());
        }
    }


}
