<?php

namespace App\Models\repair;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RepairEstimasiJrr extends Model
{
    use HasFactory;

    protected $connection = 'rumahdrone_repair';
    protected $table = 'repair_estimasi_jrr';
    protected $guarded = ['id'];

    public function estimasi()
    {
        return $this->belongsTo(RepairEstimasi::class, 'estimasi_id');
    }

    public function jenisTransaksi()
    {
        return $this->belongsTo(RepairJenisTransaksi::class, 'jenis_transaksi_id');
    }
}
