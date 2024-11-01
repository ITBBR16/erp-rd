<?php

namespace App\Models\gudang;

use App\Models\produk\ProdukSparepart;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GudangBelanjaDetail extends Model
{
    use HasFactory;

    protected $connection = 'rumahdrone_gudang';
    protected $table = 'gudang_belanja_detail';
    protected $guarded = ['id'];

    public function gudangBelanja()
    {
        return $this->belongsTo(GudangBelanja::class);
    }

    public function sparepart()
    {
        return $this->belongsTo(ProdukSparepart::class, 'sparepart_id');
    }
}
