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

    public function kategoriPermasalahan()
    {
        return $this->belongsTo(KiosKategoriPermasalahan::class, 'kategori_permasalahan_id');
    }

    public function permasalahanproduk()
    {
        return $this->belongsToMany(ProdukJenis::class, 'rumahdrone_kios.kios_recap_ts_produk', 'ts_id', 'produk_id');
    }

}
