<?php

namespace App\Models\repair;

use App\Models\employee\Employee;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use PhpParser\Node\Expr\FuncCall;

class RepairJurnal extends Model
{
    use HasFactory;

    protected $connection = 'rumahdrone_repair';
    protected $table = 'repair_jurnal';
    protected $guarded = ['id'];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    public function jenisSubStatus()
    {
        return $this->belongsTo(RepairJenisSubStatus::class, 'jenis_substatus_id');
    }

    public function timestampStatus()
    {
        return $this->belongsTo(RepairTimestampStatus::class, 'timestamp_status_id');
    }
}
