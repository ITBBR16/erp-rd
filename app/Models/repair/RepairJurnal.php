<?php

namespace App\Models\repair;

use App\Models\employee\Employee;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RepairJurnal extends Model
{
    use HasFactory;

    protected $connection = 'rumahdrone_repair';
    protected $table = 'repair_jurnal';
    protected $guarded = ['id'];

    public function case()
    {
        return $this->belongsTo(RepairCase::class, 'case_id');
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    public function jenisStatus()
    {
        return $this->belongsTo(RepairJenisStatus::class, 'jenis_status_id');
    }

    public function timestamp()
    {
        return $this->belongsTo(RepairTimestampStatus::class, 'timestamps_status_id');
    }
}
