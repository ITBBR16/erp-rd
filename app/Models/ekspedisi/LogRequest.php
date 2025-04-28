<?php

namespace App\Models\ekspedisi;

use App\Models\customer\Customer;
use App\Models\divisi\Divisi;
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

    public function divisi()
    {
        return $this->belongsTo(Divisi::class, 'divisi_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'penerima_id');
    }

    public function layananEkspedisi()
    {
        return $this->belongsTo(JenisPelayanan::class, 'layanan_id');
    }

    public function repairCase()
    {
        return $this->belongsTo(RepairCase::class, 'source_id');
    }

    public function logCase()
    {
        return $this->belongsTo(LogCase::class, 'source_id');
    }

    public function logPenerima()
    {
        return $this->belongsTo(LogPenerima::class, 'penerima_id');
    }
}
