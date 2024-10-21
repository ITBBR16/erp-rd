<?php

namespace App\Models\management;

use App\Models\repair\RepairTransaksi;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AkuntanMutasi extends Model
{
    use HasFactory;

    protected $connection = 'rumahdrone_management';
    protected $table = 'akuntan_mutasi';
    protected $guarded = ['id'];

    public function namaAkun()
    {
        return $this->belongsTo(AkuntanDaftarAkun::class, 'akun_id');
    }

    public function mergeMutasiTransaksiRepair()
    {
        return $this->belongsToMany(RepairTransaksi::class, 'rumahdrone_management.akuntan_pencocokan', 'mutasi_id', 'transaksi_id')
                    ->withPivot(['status_penjurnalan', 'catatan']);
    }
}
