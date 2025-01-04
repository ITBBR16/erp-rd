<?php

namespace App\Repositories\customer;

use App\Models\wilayah\Kota;
use App\Models\divisi\Divisi;
use App\Models\customer\Customer;
use App\Models\wilayah\Kecamatan;
use App\Models\wilayah\Kelurahan;

class CustomerRepository implements CustomerInterface
{
    public function getAll()
    {
        $dataCustomer = Customer::select('customer.*', 'provinsi.name as nama_provinsi', 'kabupaten.name as nama_kota', 'kecamatan.name as nama_kecamatan', 'kelurahan.name as nama_kelurahan')
                        ->leftJoin('provinsi', 'customer.provinsi_id', '=', 'provinsi.id')
                        ->leftJoin('kabupaten', 'customer.kota_kabupaten_id', '=', 'kabupaten.id')
                        ->leftJoin('kecamatan', 'customer.kecamatan_id', '=', 'kecamatan.id')
                        ->leftJoin('kelurahan', 'customer.kelurahan_id', '=', 'kelurahan.id')
                        ->orderBy('customer.id', 'desc')
                        ->paginate(10);

        return $dataCustomer;
    }

    public function deleteCustomer($customerId)
    {
        Customer::destroy($customerId);
    }

    public function updateCustomer($customerId, array $validate)
    {
        return Customer::whereId($customerId)->update($validate);
    }

    public function getDivisi($user){
        $divisiId = $user->divisi_id;
        if($divisiId != 0){
            $divisiName = Divisi::find($divisiId);
        } else {
            $divisiName = 'Super Admin';
        }

        return $divisiName;
    }

}
