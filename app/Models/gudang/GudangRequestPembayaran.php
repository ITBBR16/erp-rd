<?php

namespace App\Models\gudang;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GudangRequestPembayaran extends Model
{
    use HasFactory;

    protected $connection = 'rumahdrone_gudang';
    protected $table = 'gudang_request_pembayaran';
    protected $guarded = ['id'];

    public function gudangBelanja()
    {
        return $this->belongsTo(GudangBelanja::class);
    }

}
