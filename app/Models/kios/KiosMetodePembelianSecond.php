<?php

namespace App\Models\kios;

use App\Models\kios\KiosOrderSecond;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KiosMetodePembelianSecond extends Model
{
    use HasFactory;

    protected $connection = 'rumahdrone_kios';
    protected $table = 'metode_pembelian_second';
    protected $guarded = ['id'];

    public function ordersecond()
    {
        return $this->hasMany(KiosOrderSecond::class);
    }

}
