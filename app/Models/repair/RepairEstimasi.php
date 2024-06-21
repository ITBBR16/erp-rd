<?php

namespace App\Models\repair;

use App\Models\employee\Employee;
use App\Models\repair\RepairCase;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RepairEstimasi extends Model
{
    use HasFactory;

    public function case()
    {
        return $this->belongsTo(RepairCase::class, 'case_id');
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }
}
