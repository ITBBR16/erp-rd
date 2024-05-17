<?php

namespace App\Models\ekspedisi;

use Illuminate\Database\Eloquent\Model;
use App\Models\ekspedisi\PengirimanEkspedisi;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PenerimaanProduk extends Model
{
    use HasFactory;

    protected $connection = 'rumahdrone_ekspedisi';
    protected $table = 'penerimaan_barang';
    protected $guarded = ['id'];

    public function pengiriman()
    {
        return $this->belongsTo(PengirimanEkspedisi::class, 'pengiriman_ekspedisi_id');
    }

}
