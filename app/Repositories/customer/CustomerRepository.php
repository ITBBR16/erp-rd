<?php

namespace App\Repositories\customer;

use App\Models\customer\Customer;

class CustomerRepository
{
    public function getAll()
    {
        $dataCustomer = Customer::select('customer.*', 'provinsi.name as nama_provinsi', 'kabupaten.name as nama_kota', 'kecamatan.name as nama_kecamatan', 'kelurahan.name as nama_kelurahan')
                        ->leftJoin('provinsi', 'customer.provinsi', '=', 'provinsi.id')
                        ->leftJoin('kabupaten', 'customer.kota_kabupaten', '=', 'kabupaten.id')
                        ->leftJoin('kecamatan', 'customer.kecamatan', '=', 'kecamatan.id')
                        ->leftJoin('kelurahan', 'customer.kelurahan', '=', 'kelurahan.id')
                        ->get();

        return $dataCustomer;
    }

    public function getSearch()
    {
        
    }
}
