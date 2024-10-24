<?php

namespace App\Models\gudang;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GudangMetodePembayaran extends Model
{
    use HasFactory;

    protected $connection = 'rumahdrone_gudang';
    protected $table = 'gudang_metode_pembayaran';
    protected $guarded = ['id'];

    public function requestPayment()
    {
        return $this->hasMany(GudangRequestPembayaran::class);
    }
}
