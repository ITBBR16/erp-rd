<?php

namespace App\Repositories\repair\interface;

interface RepairCustomerInterface
{
    public function getAll();
    public function getDataCustomer();
    public function findCustomer($id);

    public function getProvinsi();

    public function createCustomer(array $validate);
    public function deleteCustomer($customerId);
    public function updateCustomer($customerId, array $validate);
}