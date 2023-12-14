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

    public function kategori(){
        return $this->belongsTo(ProdukSubJenis::class);
    }
}
