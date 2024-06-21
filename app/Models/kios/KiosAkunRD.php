<?php

namespace App\Models\kios;

use App\Models\repair\RepairTransaksiPembayaran;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KiosAkunRD extends Model
{
    use HasFactory;

    protected $connection = 'rumahdrone_kios';
    protected $table = 'kios_akun_rd';
    protected $guarded = ['id'];

    public function transaksi()
    {
        return $this->hasMany(KiosTransaksi::class);
    }

    public function transaksiPembayaranRepair()
    {
        return $this->hasMany(RepairTransaksiPembayaran::class);
    }
}
