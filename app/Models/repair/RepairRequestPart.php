<?php

namespace App\Models\repair;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RepairRequestPart extends Model
{
    use HasFactory;

    protected $connection = 'rumahdrone_repair';
    protected $table = 'repair_request_part';
    protected $guarded = ['id'];

    public function case()
    {
        return $this->belongsTo(RepairCase::class, 'case_id');
    }
    
    public function estimasi()
    {
        return $this->hasMany(RepairEstimasi::class);
    }
}
