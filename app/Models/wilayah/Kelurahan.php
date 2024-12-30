<?php

namespace App\Models\wilayah;

use App\Models\customer\Customer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelurahan extends Model
{
    use HasFactory;

    protected $connection = 'rumahdrone_customer';
    protected $table = 'kelurahan';
    protected $guarded = ['id'];

    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class, 'kecamatan_id');
    }

    public function customer()
    {
        return $this->hasMany(Customer::class);
    }

}
