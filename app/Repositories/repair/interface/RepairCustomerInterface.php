<?php

namespace App\Repositories\repair\interface;

interface RepairCustomerInterface
{
    public function getAll();

    public function getProvinsi();
    // public function getKota();
    // public function getKecamatan();
    // public function getKelurahan();

    public function createCustomer(array $validate);
    public function deleteCustomer($customerId);
    public function updateCustomer($customerId, array $validate);
}