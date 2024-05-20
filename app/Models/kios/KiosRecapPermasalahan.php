<?php

namespace App\Models\kios;

use App\Models\produk\ProdukJenis;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KiosRecapPermasalahan extends Model
{
    use HasFactory;

    protected $connection = 'rumahdrone_kios';
    protected $table = 'kios_recap_permasalahan';
    protected $guarded = ['id'];

    public function dailyrecap()
    {
        return $this->hasMany(KiosDailyRecap::class);
    }

    public function permasalahanproduk()
    {
        return $this->belongsToMany(ProdukJenis::class, 'permasalahan_produk', 'permasalahan_id', 'jenis_id');
    }

}
