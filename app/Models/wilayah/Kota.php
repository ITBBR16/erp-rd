<?php

namespace App\Models\wilayah;

use App\Models\customer\Customer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kota extends Model
{
    use HasFactory;

    protected $connection = 'rumahdrone_customer';
    protected $table = 'kabupaten';
    protected $guarded = ['id'];

    public function kecamatan()
    {
        return $this->hasMany(Kecamatan::class);
    }

    public function provinsi()
    {
        return $this->belongsTo(Provinsi::class, 'provinsi_id');
    }

    public function customer()
    {
        return $this->hasMany(Customer::class, 'kota_kabupaten');
    }

}
