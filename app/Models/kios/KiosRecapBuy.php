<?php

namespace App\Models\kios;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KiosRecapBuy extends Model
{
    use HasFactory;

    protected $connection = 'rumahdrone_kios';
    protected $table = 'kios_recap_buy';
    protected $guarded = ['id'];

    public function transaksiKiosBaru()
    {
        return $this->belongsTo(KiosTransaksi::class, 'transaksi_id');
    }
}
