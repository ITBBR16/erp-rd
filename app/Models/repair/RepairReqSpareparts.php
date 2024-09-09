<?php

namespace App\Models\repair;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RepairReqSpareparts extends Model
{
    use HasFactory;

    protected $connection = 'rumahdrone_repair';
    protected $table = 'repair_request_part';
    protected $guarded = ['id'];

    public function repairCase()
    {
        return $this->belongsTo(RepairCase::class, 'case_id');
    }
}
