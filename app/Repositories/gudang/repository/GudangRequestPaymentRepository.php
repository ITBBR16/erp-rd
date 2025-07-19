<?php

namespace App\Repositories\gudang\repository;

use App\Models\gudang\GudangMetodePembayaran;
use App\Models\gudang\GudangRequestPembayaran;
use App\Repositories\gudang\interface\GudangRequestPaymentInterface;

class GudangRequestPaymentRepository implements GudangRequestPaymentInterface
{
    public function __construct(
        private GudangRequestPembayaran $reqPayment,
        private GudangMetodePembayaran $metodePembayaran
    ) {}

    public function getDataRequestPayment()
    {
        return $this->reqPayment->all();
    }

    public function findPayment($id)
    {
        return $this->reqPayment->find($id);
    }

    public function createPayment(array $data)
    {
        return $this->reqPayment->create($data);
    }

    public function updatePayment($id, array $data)
    {
        $payment = $this->reqPayment->find($id);
        if ($payment) {
            $payment->update($data);
            return $payment;
        }

        throw new \Exception("Payment not found.");
    }

    public function createOrNotMp(array $attributes, array $values = [])
    {
        $model = $this->metodePembayaran->where($attributes)->first();

        if (!$model) {
            $model = $this->metodePembayaran->create(array_merge($attributes, $values));
        }

        return $model;
    }
}
