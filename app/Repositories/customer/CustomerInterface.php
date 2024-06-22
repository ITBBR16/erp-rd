<?php

namespace App\Repositories\customer;

interface CustomerInterface
{
    public function getAll();
    public function getDivisi($user);

    public function getSelectKota();
    public function getSelectKecamatan();
    public function getSelectKelurahan();

    public function deleteCustomer($customerId);
    public function updateCustomer($customerId, array $validate);
}