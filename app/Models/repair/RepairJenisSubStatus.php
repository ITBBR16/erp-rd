<?php

namespace App\Models\repair;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RepairJenisSubStatus extends Model
{
    use HasFactory;

    protected $connection = 'rumahdrone_repair';
    protected $table = 'repair_jenis_substatus';
    protected $guarded =['id'];

    public function jurnal()
    {
        return $this->hasMany(RepairJurnal::class);
    }

    public function jenisStatus()
    {
        return $this->belongsTo(RepairJenisStatus::class, 'jenis_status_id');
    }
}
