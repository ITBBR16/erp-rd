<?php

namespace App\Repositories\gudang\interface;

interface GudangRequestPaymentInterface
{
    public function getDataRequestPayment();
    public function findPayment($id);
    public function createOrNotMp(array $attributes, array $values = []);
    public function updatePayment($id, array $data);
}
