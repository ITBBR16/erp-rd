<?php

namespace App\Models\gudang;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GudangPengiriman extends Model
{
    use HasFactory;

    protected $connection = 'rumahdrone_gudang';
    protected $table = 'gudang_pengiriman';
    protected $guarded = ['id'];

    public function gudangBelanja()
    {
        return $this->belongsTo(GudangBelanja::class);
    }
}
