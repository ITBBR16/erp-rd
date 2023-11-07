<?php

namespace App\Http\Controllers\customer;

use App\Http\Controllers\Controller;
use App\Models\customer\Customer;
use App\Models\wilayah\Provinsi;
use Illuminate\Http\Request;

class AddCustomerController extends Controller
{
    public function index()
    {
        $provinsi = Provinsi::all();

        return view('customer.main.add-customer', [
            'title' => 'Add Customer',
            'active' => 'add-customer',
            'provinsi' => $provinsi
        ]);
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            'first_name' => 'required|max:50',
            'last_name' => 'required|max:50',
            'no_telpon' => 'required|regex:/^62\d{9,}$/',
            'email' => 'nullable|email:dns',
            'instansi' => 'max:50',
            'provinsi' => 'required',
            'kota_kabupaten' => 'required',
            'kecamatan' => 'required',
            'kelurahan' => 'required',
            'kode_pos' => 'required|numeric|digits:5',
            'nama_jalan' => 'required|max:255'
        ]);

        dd($validate);
        // Customer::create($validate);

        return redirect('/customer/add-customer')->with('success', 'Success Add New Customer !!');

    }

}
