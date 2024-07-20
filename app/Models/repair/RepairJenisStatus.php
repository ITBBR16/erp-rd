<?php

namespace App\Models\repair;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RepairJenisStatus extends Model
{
    use HasFactory;

    protected $connection = 'rumahdrone_repair';
    protected $table = 'repair_jenis_status';
    protected $guarded = ['id'];

    public function case()
    {
        return $this->hasMany(RepairCase::class);
    }

    public function timestampStatus()
    {
        return $this->hasMany(RepairTimestampStatus::class);
    }

    public function jenisSubStatus()
    {
        return $this->hasMany(RepairJenisSubStatus::class);
    }
}
