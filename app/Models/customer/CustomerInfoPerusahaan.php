<?php

namespace App\Models\customer;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerInfoPerusahaan extends Model
{
    use HasFactory;

    protected $connection = 'rumahdrone_customer';
    protected $table = 'customer_info_perusahaan';
    protected $guarded = ['id'];

    public function customerdata()
    {
        return $this->hasMany(Customer::class);
    }

}
