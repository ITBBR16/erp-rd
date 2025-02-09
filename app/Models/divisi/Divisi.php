<?php

namespace App\Models\divisi;

use App\Models\ekspedisi\LogRequest;
use App\Models\employee\Employee;
use Illuminate\Database\Eloquent\Model;
use App\Models\ekspedisi\PengirimanEkspedisi;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Divisi extends Model
{
    use HasFactory;

    protected $connection = 'rumahdrone_employee';
    protected $table = 'divisi';

    protected $guarded = ['id'];

    public function employee() 
    {
        return $this->hasMany(Employee::class);
    }

    public function pengiriman()
    {
        return $this->hasMany(PengirimanEkspedisi::class);
    }

    public function requestLogistik()
    {
        return $this->hasMany(LogRequest::class);
    }
}
