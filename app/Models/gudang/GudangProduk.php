<?php

namespace App\Models\gudang;

use App\Models\produk\ProdukSparepart;
use App\Models\repair\RepairEstimasiPart;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GudangProduk extends Model
{
    use HasFactory;

    protected $connection = 'rumahdrone_gudang';
    protected $table = 'gudang_produk';
    protected $guarded = ['id'];

    public function produkSparepart()
    {
        return $this->belongsTo(ProdukSparepart::class, 'produk_sparepart_id', 'id');
    }

    public function gudangIdItem() // Salah
    {
        return $this->hasMany(GudangProdukIdItem::class);
    }

    public function estimasiRepair()
    {
        return $this->hasMany(RepairEstimasiPart::class, 'gudang_produk_id', 'produk_sparepart_id');
    }
}
