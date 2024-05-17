<?php

namespace App\Repositories\customer;

use App\Models\customer\Customer;
use App\Models\wilayah\Kecamatan;
use App\Models\wilayah\Kelurahan;
use App\Models\wilayah\Kota;

class CustomerRepository implements CustomerInterface
{
    public function getAll()
    {
        $dataCustomer = Customer::select('customer.*', 'provinsi.name as nama_provinsi', 'kabupaten.name as nama_kota', 'kecamatan.name as nama_kecamatan', 'kelurahan.name as nama_kelurahan')
                        ->leftJoin('provinsi', 'customer.provinsi', '=', 'provinsi.id')
                        ->leftJoin('kabupaten', 'customer.kota_kabupaten', '=', 'kabupaten.id')
                        ->leftJoin('kecamatan', 'customer.kecamatan', '=', 'kecamatan.id')
                        ->leftJoin('kelurahan', 'customer.kelurahan', '=', 'kelurahan.id')
                        ->orderBy('customer.id', 'desc')
                        ->paginate(10);

        return $dataCustomer;
    }

    public function getSelectKota()
    {
        $dataKota = Kota::select('kabupaten.*')
                    ->join('customer', 'kabupaten.provinsi_id', '=', 'customer.provinsi')
                    ->get();

        return $dataKota;
    }

    public function getSelectKecamatan()
    {
        $dataKecamatan = Kecamatan::select('kecamatan.*')
                    ->join('customer', 'kecamatan.kabupaten_id', '=', 'customer.kota_kabupaten')
                    ->get();

        return $dataKecamatan;
    }

    public function getSelectKelurahan()
    {
        $dataKelurahan = Kelurahan::select('kelurahan.*')
                    ->join('customer', 'kelurahan.kecamatan_id', '=', 'customer.kecamatan')
                    ->get();

        return $dataKelurahan;
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
