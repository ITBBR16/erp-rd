<?php

namespace App\Models\wilayah;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Provinsi extends Model
{
    use HasFactory;

    protected $connection = 'rumahdrone_customer';

    protected $table = 'provinsi';

    public function kota()
    {
        return $this->hasMany(Kota::class, 'provinsi_id', 'id');
    }
}
