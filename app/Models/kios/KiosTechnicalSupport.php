<?php

namespace App\Models\kios;

use App\Models\produk\ProdukJenis;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KiosTechnicalSupport extends Model
{
    use HasFactory;

    protected $connection = 'rumahdrone_kios';
    protected $table = 'kios_technical_support';
    protected $guarded = ['id'];

    public function recapTs()
    {
        return $this->hasMany(KiosRecapTechnicalSupport::class);
    }

    public function permasalahanproduk()
    {
        return $this->belongsToMany(ProdukJenis::class, 'permasalahan_produk', 'permasalahan_id', 'jenis_id');
    }

}
