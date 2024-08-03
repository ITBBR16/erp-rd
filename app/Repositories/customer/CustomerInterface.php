<?php

namespace App\Repositories\customer;

interface CustomerInterface
{
    public function getAll();
    public function getDivisi($user);

    public function deleteCustomer($customerId);
    public function updateCustomer($customerId, array $validate);
}