<?php

namespace App\Models\repair;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RepairJenisTransaksi extends Model
{
    use HasFactory;

    protected $connection = 'rumahdrone_repair';
    protected $table = 'repair_jenis_transaksi';
    protected $guarded = ['id'];

    public function estimasiJrr()
    {
        return $this->hasMany(RepairEstimasiJRR::class);
    }

    public function estimasiPart()
    {
        return $this->hasMany(RepairEstimasiPart::class);
    }

}
