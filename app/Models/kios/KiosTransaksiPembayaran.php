<?php

namespace App\Models\kios;

use App\Models\employee\Employee;
use App\Models\management\AkuntanDaftarAkun;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KiosTransaksiPembayaran extends Model
{
    use HasFactory;

    protected $connection = 'rumahdrone_kios';
    protected $table = 'kios_transaksi_pembayaran';
    protected $guarded = ['id'];

    public function transaksi()
    {
        return $this->belongsTo(KiosTransaksi::class, 'transaksi_id');
    }

    public function daftarAkunManagement()
    {
        return $this->belongsTo(AkuntanDaftarAkun::class, 'metode_pembayaran_id');
    }

}
