<?php

namespace App\Models\kios;

use App\Models\produk\ProdukSubJenis;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KiosWTS extends Model
{
    use HasFactory;

    protected $connection = 'rumahdrone_kios';
    protected $table = 'kios_want_to_sell';
    protected $guarded = ['id'];

    public function kiosDR()
    {
        return $this->hasOne(KiosDailyRecap::class);
    }

    public function subjenis()
    {
        return $this->belongsTo(ProdukSubJenis::class, 'paket_penjualan_id');
    }

}
