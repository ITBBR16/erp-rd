<?php

namespace App\Models\produk;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProdukSubJenis extends Model
{
    use HasFactory;

    protected $connection = 'rumahdrone_produk';
    protected $table = 'produk_sub_jenis';
    protected $guarded = ['id'];

    public function kelengkapan(){
        return $this->belongsToMany(ProdukKelengkapan::class, 'produk_sub_kelengkapan');
    }
}
