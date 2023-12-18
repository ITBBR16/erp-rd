<?php

namespace App\Models\produk;

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
        return $this->hasMany(ProdukKelengkapan::class, 'produk_jenis_id');
    }

}
