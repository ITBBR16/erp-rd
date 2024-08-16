<?php

namespace App\Models\repair;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RepairTimestampStatus extends Model
{
    use HasFactory;

    protected $connection = 'rumahdrone_repair';
    protected $table = 'repair_timestamp_status';
    protected $guarded = ['id'];

    public function repairCase()
    {
        return $this->belongsTo(RepairCase::class, 'case_id');
    }

    public function jurnal()
    {
        return $this->hasMany(RepairJurnal::class, 'timestamps_status_id');
    }

}
