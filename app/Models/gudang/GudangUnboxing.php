<?php

namespace App\Models\gudang;

use App\Models\employee\Employee;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GudangUnboxing extends Model
{
    use HasFactory;

    protected $connection = 'rumahdrone_gudang';
    protected $table = 'gudang_unboxing';
    protected $guarded = ['id'];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    public function gudangBelanja()
    {
        return $this->belongsTo(GudangBelanja::class, 'gudang_belanja_id');
    }

    public function gudangPengiriman()
    {
        return $this->belongsTo(GudangPengiriman::class, 'gudang_pengiriman_id');
    }
}
