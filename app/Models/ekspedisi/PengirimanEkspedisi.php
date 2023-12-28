<?php

namespace App\Models\ekspedisi;

use App\Models\divisi\Divisi;
use App\Models\kios\KiosOrder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengirimanEkspedisi extends Model
{
    use HasFactory;

    protected $connection = 'rumahdrone_ekspedisi';
    protected $table = 'pengiriman_ekspedisi';
    protected $guarded = ['id'];

    public function pelayanan()
    {
        return $this->belongsTo(JenisPelayanan::class, 'jenis_layanan_id');
    }

    public function order()
    {
        return $this->belongsTo(KiosOrder::class);
    }

    public function divisi()
    {
        return $this->belongsTo(Divisi::class);
    }

    public function penerimaan()
    {
        return $this->hasMany(PenerimaanProduk::class);
    }
}
