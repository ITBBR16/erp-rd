<?php

namespace App\Models\repair;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RepairQCFisik extends Model
{
    use HasFactory;

    protected $connection = 'rumahdrone_repair';
    protected $table = 'repair_cek_fisik';
    protected $guarded = ['id'];

    public function qualityControl()
    {
        return $this->belongsTo(RepairQualityControl::class, 'qc_id');
    }

    public function qcKategori()
    {
        return $this->belongsTo(RepairQCKategori::class, 'kategori_cek_id');
    }

    public function qcKondisi()
    {
        return $this->belongsTo(RepairQCKondisi::class, 'kondisi_id');
    }
}
