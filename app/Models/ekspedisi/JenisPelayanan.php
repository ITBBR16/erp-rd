<?php

namespace App\Models\ekspedisi;

use App\Models\ekspedisi\Ekspedisi;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JenisPelayanan extends Model
{
    use HasFactory;

    protected $connection = 'rumahdrone_ekspedisi';
    protected $table = 'jenis_layanan';
    protected $guarded = ['id'];

    public function ekspedisi()
    {
        return $this->belongsTo(Ekspedisi::class, 'ekspedisi_id');
    }

    public function pengiriman()
    {
        return $this->hasMany(JenisPelayanan::class);
    }
}
