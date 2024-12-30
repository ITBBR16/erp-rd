<?php

namespace App\Models\wilayah;

use App\Models\customer\Customer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kecamatan extends Model
{
    use HasFactory;

    protected $connection = 'rumahdrone_customer';
    protected $table = 'kecamatan';
    protected $guarded = ['id'];

    public function kelurahan()
    {
        return $this->hasMany(Kelurahan::class);
    }

    public function kota()
    {
        return $this->belongsTo(Kota::class, 'kabupaten_id');
    }

    public function customer()
    {
        return $this->hasMany(Customer::class);
    }

}
