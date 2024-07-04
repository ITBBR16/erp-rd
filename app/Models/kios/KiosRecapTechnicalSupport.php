<?php

namespace App\Models\kios;

use App\Models\produk\ProdukJenis;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KiosRecapTechnicalSupport extends Model
{
    use HasFactory;

    protected $connection = 'rumahdrone_kios';
    protected $table = 'kios_recap_ts';
    protected $guarded = ['id'];

    public function technicalSupport()
    {
        return $this->belongsTo(KiosTechnicalSupport::class, 'kios_ts_id');
    }

    public function kiosDR()
    {
        return $this->hasOne(KiosDailyRecap::class);
    }

    public function produkJenis()
    {
        return $this->belongsTo(ProdukJenis::class, 'jenis_id');
    }

    public function kategoriPermasalahan()
    {
        return $this->belongsTo(KiosKategoriPermasalahan::class, 'kategori_permasalahan_id');
    }

}
