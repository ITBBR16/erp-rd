<?php

namespace App\Models\repair;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RepairTimestampStatus extends Model
{
    use HasFactory;

    protected $connection = 'rumahdrone_repair';
    protected $table = 'repair_timestamp_status';
    protected $guarded =['id'];

    public function jurnal()
    {
        return $this->hasMany(RepairJurnal::class);
    }

    public function case()
    {
        return $this->belongsTo(RepairCase::class, 'case_id');
    }

    public function jenisStatus()
    {
        return $this->belongsTo(RepairJenisStatus::class, 'jenis_status_id');
    }
}
