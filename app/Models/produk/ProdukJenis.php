<?php

namespace App\Models\produk;

use App\Models\kios\KiosRecapTechnicalSupport;
use App\Models\kios\KiosTechnicalSupport;
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
        return $this->belongsToMany(ProdukSubJenis::class, 'produk_jenis_paket_penjualan', 'jenis_id', 'paket_penjualan_id');
    }

    public function produkkategori(){
        return $this->belongsTo(ProdukKategori::class);
    }

    public function kelengkapans(){
        return $this->belongsToMany(ProdukKelengkapan::class, 'produk_jenis_kelengkapan');
    }

    public function produkpermasalahan()
    {
        return $this->belongsToMany(KiosTechnicalSupport::class, 'rumahdrone_kios.kios_recap_ts_produk', 'produk_id', 'ts_id');
    }

    public function kiosRecapTs()
    {
        return $this->hasMany(KiosRecapTechnicalSupport::class);
    }

    public function repiarCase()
    {
        return $this->hasMany(RepairCase::class);
    }

}
