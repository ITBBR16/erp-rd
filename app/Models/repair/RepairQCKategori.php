<?php

namespace App\Models\repair;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RepairQCKategori extends Model
{
    use HasFactory;

    protected $connection = 'rumahdrone_repair';
    protected $table = 'repair_kategori_cek_qc';
    protected $guarded = ['id'];

    public function qcFisik()
    {
        return $this->hasMany(RepairQCFisik::class, 'kategori_cek_id');
    }

    public function qcCalibrasi()
    {
        return $this->hasMany(RepairQCCalibrasi::class, 'kategori_cek_id');
    }

    public function qcTestFlye()
    {
        return $this->hasMany(RepairQCTestFly::class, 'kategori_cek_id');
    }
}
