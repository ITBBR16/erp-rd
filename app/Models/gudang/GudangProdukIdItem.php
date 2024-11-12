<?php

namespace App\Models\gudang;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GudangProdukIdItem extends Model
{
    use HasFactory;

    protected $connection = 'rumahdrone_gudang';
    protected $table = 'gudang_produk_id_item';
    protected $guarded = ['id'];

    public function gudangBelanja()
    {
        return $this->belongsTo(GudangBelanja::class, 'gudang_belanja_id');
    }

    public function gudangProduk()
    {
        return $this->belongsTo(GudangProduk::class, 'gudang_produk_id');
    }

    public function qualityControll()
    {
        return $this->hasOne(GudangQualityControll::class);
    }

}
