<?php

namespace App\Http\Controllers\customer;

use App\Http\Controllers\Controller;
use App\Models\customer\Customer;
use App\Models\wilayah\Provinsi;
use App\Repositories\customer\CustomerRepository;
use Illuminate\Http\Request;

class DashboardCustomerController extends Controller
{
    public function __construct(private CustomerRepository $customerRepo){}

    public function index() 
    {
        $dataCustomer = $this->customerRepo->getAll();
        $dataKota = $this->customerRepo->getSelectKota();
        $dataKecamatan = $this->customerRepo->getSelectKecamatan();
        $dataKelurahan = $this->customerRepo->getSelectKelurahan();
        $provinsi = Provinsi::all();

        return view('customer.main.index', [
            'title' => 'Dashboard Customer',
            'active' => 'dashboard-customer',
            'dataCustomer' => $dataCustomer,
            'dataKota' => $dataKota,
            'dataKecamatan' => $dataKecamatan,
            'dataKelurahan' => $dataKelurahan,
            'provinsi' => $provinsi
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
