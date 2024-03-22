<?php

namespace App\Models\kios;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KiosTransaksiDetail extends Model
{
    use HasFactory;

    protected $connection = 'rumahdrone_kios';
    protected $table = 'kios_transaksi_detail';
    protected $guarded = ['id'];

    public function transaksi()
    {
        return $this->belongsTo(KiosTransaksi::class, 'kios_transaksi_id');
    }

    public function serialnumbers()
    {
        return $this->belongsTo(KiosSerialNumber::class, 'serial_number_id');
    }
}
