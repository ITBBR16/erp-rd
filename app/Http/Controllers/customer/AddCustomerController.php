<?php

namespace App\Http\Controllers\customer;

use Illuminate\Http\Request;
use App\Models\divisi\Divisi;
use Illuminate\Validation\Rule;
use App\Models\wilayah\Provinsi;
use App\Models\customer\Customer;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class AddCustomerController extends Controller
{
    public function index()
    {
        $provinsi = Provinsi::all();
        $divisiId = auth()->user()->divisi_id;
        $divisiName = Divisi::find($divisiId);

        return view('customer.main.add-customer', [
            'title' => 'Add Customer',
            'active' => 'add-customer',
            'provinsi' => $provinsi,
            'divisi' => $divisiName,
        ]);
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            'first_name' => 'required|max:50',
            'last_name' => 'required|max:50',
            'no_telpon' => ['required', 'regex:/^62\d{9,}$/', Rule::unique('rumahdrone_customer.customer', 'no_telpon')],
            'email' => 'nullable|email:dns',
            'instansi' => 'max:50',
            'provinsi' => 'required',
            'kota_kabupaten' => 'required',
            'kecamatan' => 'required',
            'kelurahan' => 'required',
            'kode_pos' => 'required|numeric|digits:5',
            'nama_jalan' => 'required|max:255'
        ]);

        $appScriptUrl = 'https://script.google.com/macros/s/AKfycbyFTLvq0HaGhnZBjSWH3JLKuRntth2wBKoltkFrGwWQM0UHjG6BMLeaM3guaz9mLCS8/exec';
        $response = Http::post($appScriptUrl, [
            'first_name' => $validate['first_name'],
            'last_name' => $validate['last_name'],
            'email' => $validate['email'],
            'no_telpon' => $validate['no_telpon'],
        ]);

        if($response->successful()) {
            Customer::create($validate);
            return redirect('/customer/add-customer')->with('success', 'Success Add New Customer !!');
        } else {
            return redirect('/customer/add-customer')->with('error', 'Failed to Save Contact. Please try again.');
        }
    }

}
