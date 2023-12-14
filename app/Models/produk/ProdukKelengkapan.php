<?php

namespace App\Models\produk;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProdukKelengkapan extends Model
{
    use HasFactory;

    protected $connection = 'rumahdrone_produk';
    protected $table = 'produk_kelengkapan';
    protected $guarded = ['id'];

    public function subJenis(){
        return $this->belongsToMany(ProdukSubJenis::class, 'produk_sub_kelengkapan');
    }
}
