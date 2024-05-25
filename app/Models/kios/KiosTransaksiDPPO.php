<?php

namespace App\Models\kios;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KiosTransaksiDPPO extends Model
{
    use HasFactory;

    protected $connection = 'rumahdrone_kios';
    protected $table = 'kios_transaksi_dp';
    protected $guarded = ['id'];

    public function transaksi()
    {
        return $this->belongsTo(KiosTransaksi::class, 'kios_transaksi_id');
    }
}
