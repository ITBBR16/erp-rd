<?php

namespace App\Models\repair;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RepairQualityControl extends Model
{
    use HasFactory;

    protected $connection = 'rumahdrone_repair';
    protected $table = 'repair_quality_control';
    protected $guarded = ['id'];

    public function cekFisik()
    {
        return $this->hasMany(RepairQCFisik::class, 'qc_id');
    }

    public function cekCalibrasi()
    {
        return $this->hasMany(RepairQCCalibrasi::class, 'qc_id');
    }

    public function testFly()
    {
        return $this->hasMany(RepairQCTestFly::class, 'qc_id');
    }

}
