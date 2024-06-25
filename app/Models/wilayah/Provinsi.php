<?php

namespace App\Models\wilayah;

use App\Models\customer\Customer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Provinsi extends Model
{
    use HasFactory;

    protected $connection = 'rumahdrone_customer';
    protected $table = 'provinsi';
    protected $guarded = ['id'];

    public function customer()
    {
        return $this->hasMany(Customer::class);
    }

    public function kota()
    {
        return $this->hasMany(Kota::class);
    }

}
