<?php

namespace App\Repositories\repair\repository;

use App\Models\wilayah\Kota;
use App\Models\wilayah\Provinsi;
use App\Models\customer\Customer;
use App\Models\wilayah\Kecamatan;
use App\Models\wilayah\Kelurahan;
use App\Repositories\repair\interface\RepairCustomerInterface;

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

    public function deleteCustomer($customerId)
    {
        Customer::destroy($customerId);
    }

    public function updateCustomer($customerId, array $validate)
    {
        return Customer::whereId($customerId)->update($validate);
    }

}
