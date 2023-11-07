<?php

namespace App\Http\Controllers\customer;

use App\Http\Controllers\Controller;
use App\Models\customer\Customer;
use App\Repositories\customer\CustomerRepository;
use Illuminate\Http\Request;

class DashboardCustomerController extends Controller
{
    private $customerRepo;

    public function __construct(CustomerRepository $customerRepo)
    {
        $this->customerRepo = $customerRepo;
    }

    public function index() 
    {
        $dataCustomer = $this->customerRepo->getAll();

        return view('customer.main.index', [
            'title' => 'Dashboard Customer',
            'active' => 'dashboard-customer',
            'dataCustomer' => $dataCustomer,
        ]);
    }

    public function update(Request $request, string $id)
    {
        $validate = $request->validate([
            'first_name' => 'required|max:50',
            'last_name' => 'required|max:50',
            'no_telpon' => 'required|unique:customer|regex:/^62\d{9,}$/',
            'email' => 'nullable|email:dns',
            'instansi' => 'max:50',
            'provinsi' => 'required',
            'kota_kabupaten' => 'required',
            'kecamatan' => 'required',
            'kelurahan' => 'required',
            'kode_pos' => 'required|numeric|digits:5',
            'nama_jalan' => 'required|max:255'
        ]);

        Customer::find($id)->update($validate);

        return back()->with('success', 'Success Update Customer Data');
    }

    public function destroy(string $id)
    {
        Customer::destroy($id);

        return back()->with('success', 'Success Delete Data');
    }

}
