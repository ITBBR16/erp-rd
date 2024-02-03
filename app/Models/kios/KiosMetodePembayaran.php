<?php

namespace App\Models\kios;

use App\Models\kios\KiosPayment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KiosMetodePembayaran extends Model
{
    use HasFactory;

    protected $connection = 'rumahdrone_kios';
    protected $table = 'metode_pembayaran_supplier';
    protected $guarded = ['id'];

    public function payment()
    {
        return $this->hasMany(KiosPayment::class);
    }
}
