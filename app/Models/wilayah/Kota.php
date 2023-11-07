<?php

namespace App\Models\wilayah;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kota extends Model
{
    use HasFactory;

    protected $connection = 'rumahdrone_customer';

    protected $table = 'kabupaten';

    public function kecamatan()
    {
        return $this->hasMany(Kecamatan::class, 'kabupaten_id', 'id');
    }
}
