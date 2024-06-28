<?php

namespace App\Repositories\repair\repository;

use App\Models\wilayah\Kota;
use App\Models\wilayah\Provinsi;
use App\Models\customer\Customer;
use App\Models\wilayah\Kecamatan;
use App\Models\wilayah\Kelurahan;
use App\Repositories\repair\interface\RepairCustomerInterface;
use Illuminate\Validation\Rule;

class RepairCustomerRepository implements RepairCustomerInterface
{
    public function getAll()
    {
        $dataCustomer = Customer::with('provinsi')->orderBy('id', 'desc')->paginate(10);
        return $dataCustomer;
    }
 
    public function getProvinsi()
    {
        $dataProvinsi = Provinsi::all();
        return $dataProvinsi;
    }

    // public function getKota()
    // {
    //     $dataKota = Kota::all();
    //     return $dataKota;
    // }

    // public function getKecamatan()
    // {
    //     $dataKecamatan = Kecamatan::all();
    //     return $dataKecamatan;
    // }

    // public function getKelurahan()
    // {
    //     $dataKelurahan = Kelurahan::all();
    //     return $dataKelurahan;
    // }
  
    public function createCustomer($validate)
    {
        $divisiId = auth()->user()->divisi_id;

            $validate = $validate->validate([
                'first_name' => 'required',
                'last_name' => 'required',
                'asal_informasi' => 'required',
                'no_telpon' => ['required' , 'regex:/^62\d{9,}$/', Rule::unique('rumahdrone_customer.customer', 'no_telpon')],
                'email' => 'required|email:dns',
                'instansi' => 'max:255',
                'provinsi' => 'required',
                'nama_jalan' => 'required',
            ]);

            $validate['by_divisi'] = $divisiId;
        
        Customer::create($validate);
    }

    public function deleteCustomer($customerId)
    {
        Customer::destroy($customerId);
    }

    public function updateCustomer($customerId, array $validate)
    {
        return Customer::whereId($customerId)->update($validate);
    }


}
