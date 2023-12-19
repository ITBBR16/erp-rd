<?php

namespace App\Models\produk;

use App\Models\kios\KiosOrderList;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProdukSubJenis extends Model
{
    use HasFactory;

    protected $connection = 'rumahdrone_produk';
    protected $table = 'produk_sub_jenis';
    protected $guarded = ['id'];

    public function kelengkapans(){
        return $this->belongsToMany(ProdukKelengkapan::class, 'produk_sub_kelengkapan');
    }

    public function produkjenis()
    {
        return $this->belongsTo(ProdukJenis::class, 'jenis_id');
    }

    public function orderLists()
    {
        return $this->hasMany(KiosOrderList::class);
    }
}
