<?php

namespace App\Models\kios;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KiosKategoriPermasalahan extends Model
{
    use HasFactory;

    protected $connection = 'rumahdrone_kios';
    protected $table = 'kios_kategori_permasalahan';
    protected $guarded = ['id'];

    public function dailyrecap()
    {
        return $this->hasMany(KiosDailyRecap::class);
    }

    public function kiosTS()
    {
        return $this->hasMany(KiosTechnicalSupport::class);
    }

    public function kiosRecapTs()
    {
        return $this->hasMany(KiosRecapTechnicalSupport::class);
    }

}
