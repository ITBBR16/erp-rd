<?php

namespace App\Repositories\repair\repository;

use App\Models\wilayah\Provinsi;
use App\Models\customer\Customer;
use App\Models\wilayah\Kecamatan;
use App\Models\wilayah\Kelurahan;
use App\Models\wilayah\Kota;
use Illuminate\Support\Facades\DB;
use App\Repositories\repair\interface\RepairCustomerInterface;

class RepairCustomerRepository implements RepairCustomerInterface
{

    protected $model, $connection;

    public function __construct(Customer $customer)
    {
        $this->model = $customer;
        $this->connection = DB::connection('rumahdrone_customer');
    }

    public function beginTransaction()
    {
        $this->connection->beginTransaction();
    }

    public function commitTransaction()
    {
        $this->connection->commit();
    }

    public function rollbackTransaction()
    {
        $this->connection->rollBack();
    }

    public function createCustomer(array $validate)
    {
        return $this->model->create($validate);
    }

    public function getDataCustomer()
    {
        return $this->model->all();
    }

    public function findCustomer($id)
    {
        return $this->model->findOrFail($id);
    }

    public function findByPhoneNumber($noTelpon)
    {
        return $this->model->where('no_telpon', $noTelpon)->first();
    }

    public function getProvinsi()
    {
        $dataProvinsi = Provinsi::all();
        return $dataProvinsi;
    }

    public function getKota()
    {
        $dataProvinsi = Kota::all();
        return $dataProvinsi;
    }

    public function getKecamatan()
    {
        $dataProvinsi = Kecamatan::all();
        return $dataProvinsi;
    }

    public function getKelurahan()
    {
        $dataProvinsi = Kelurahan::all();
        return $dataProvinsi;
    }

    public function updateCustomer($customerId, array $validate)
    {
        $customerSearch = $this->model->findOrFail($customerId);
        $customerSearch->update($validate);
        return $customerSearch;
    }

    // Butuh atau tidak belum tau
    public function deleteCustomer($customerId)
    {
        Customer::destroy($customerId);
    }

    public function getAll()
    {
        $dataCustomer = Customer::with('provinsi')->orderBy('id', 'desc')->paginate(10);
        return $dataCustomer;
    }

}
