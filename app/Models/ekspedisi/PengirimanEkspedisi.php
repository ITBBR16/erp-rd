<?php

namespace App\Models\ekspedisi;

use App\Models\divisi\Divisi;
use App\Models\kios\KiosOrder;
use App\Models\kios\KiosOrderSecond;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengirimanEkspedisi extends Model
{
    use HasFactory;

    protected $connection = 'rumahdrone_ekspedisi';
    protected $table = 'pengiriman_ekspedisi';
    protected $guarded = ['id'];

    public function ekspedisi()
    {
        return $this->belongsTo(Ekspedisi::class, 'ekspedisi_id');
    }

    public function validasibarang()
    {
        return $this->hasMany(ValidasiProduk::class);
    }

    public function order()
    {
        return $this->belongsTo(KiosOrder::class, 'order_id');
    }

    public function divisi()
    {
        return $this->belongsTo(Divisi::class);
    }

    public function penerimaan()
    {
        return $this->hasOne(PenerimaanProduk::class);
    }

    public function ordersecond()
    {
        return $this->belongsTo(KiosOrderSecond::class, 'order_id');
    }

}
