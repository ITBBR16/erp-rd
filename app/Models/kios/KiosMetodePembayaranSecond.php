<?php

namespace App\Models\kios;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KiosMetodePembayaranSecond extends Model
{
    use HasFactory;

    protected $connection = 'rumahdrone_kios';
    protected $table = 'kios_metode_pembayaran_second';
    protected $guarded = ['id'];

    public function payment()
    {
        return $this->hasMany(KiosPayment::class);
    }
}
