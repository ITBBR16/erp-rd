<?php

namespace App\Models\produk;

use App\Models\kios\KiosDailyRecap;
use App\Models\kios\KiosOrderList;
use App\Models\repair\RepairCase;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProdukJenis extends Model
{
    use HasFactory;

    protected $connection = 'rumahdrone_produk';
    protected $table = 'produk_jenis';
    protected $guarded = ['id'];

    public function subjenis()
    {
        return $this->hasMany(ProdukSubJenis::class, 'jenis_id');
    }

    public function produkkategori(){
        return $this->belongsTo(ProdukKategori::class);
    }

    public function kelengkapans(){
        return $this->belongsToMany(ProdukKelengkapan::class, 'produk_jenis_kelengkapan');
    }

    public function produkpermasalahan()
    {
        return $this->belongsToMany(KiosDailyRecap::class, 'permasalahan_produk', 'jenis_id', 'permasalahan_id');
    }

    //relasi repair

    public function repairCase()
    {
        return $this->hasMany(RepairCase::class);
    }

}
