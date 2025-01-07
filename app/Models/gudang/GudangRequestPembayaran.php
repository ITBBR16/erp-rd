<?php

namespace App\Models\gudang;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GudangRequestPembayaran extends Model
{
    use HasFactory;

    protected $connection = 'rumahdrone_gudang';
    protected $table = 'gudang_request_payment';
    protected $guarded = ['id'];

    public function gudangBelanja()
    {
        return $this->belongsTo(GudangBelanja::class);
    }

    public function metodePembayaran()
    {
        return $this->belongsTo(GudangMetodePembayaran::class, 'gudang_metode_pembayaran_id');
    }

}
