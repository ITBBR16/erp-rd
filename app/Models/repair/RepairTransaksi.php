<?php

namespace App\Models\repair;

use App\Models\customer\Customer;
use App\Models\employee\Employee;
use App\Models\repair\RepairCase;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RepairTransaksi extends Model
{
    use HasFactory;

    protected $connection = 'rumahdrone_repair';
    protected $table = 'repair_transaksi';
    protected $guarded = ['id'];

    public function case()
    {
        return $this->belongsTo(RepairCase::class, 'case_id');
    }
    
    public function transaksiPembayaran()
    {
        return $this->hasMany(RepairTransaksiPembayaran::class);
    }

}
