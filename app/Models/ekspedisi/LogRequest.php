<?php

namespace App\Models\ekspedisi;

use App\Models\employee\Employee;
use App\Models\repair\RepairCase;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogRequest extends Model
{
    use HasFactory;

    protected $connection = 'rumahdrone_ekspedisi';
    protected $table = 'log_request';
    protected $guarded = ['id'];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    public function logPenerima()
    {
        return $this->belongsTo(LogPenerima::class);
    }

    public function repairCase()
    {
        return $this->belongsTo(RepairCase::class, 'source_id');
    }
}
