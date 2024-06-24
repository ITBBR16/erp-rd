<?php

namespace App\Models\repair;

use App\Models\employee\Employee;
use App\Models\repair\RepairCase;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RepairEstimasi extends Model
{
    use HasFactory;

    protected $connection = 'rumahdrone_repair';
    protected $table = 'repair_estimasi';
    protected $guarded = ['id'];

    public function case()
    {
        return $this->belongsTo(RepairCase::class, 'case_id');
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    public function estimasiChat()
    {
        return $this->hasMany(RepairEstimasiChat::class);
    }
}
