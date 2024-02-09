<?php

namespace App\Models\kios;

use App\Models\customer\Customer;
use App\Models\employee\Employee;
use App\Models\produk\ProdukStatus;
use App\Models\produk\ProdukSubJenis;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KiosDailyRecap extends Model
{
    use HasFactory;

    protected $connection = 'rumahdrone_kios';
    protected $table = 'daily_recap';
    protected $guarded = ['id'];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function subjenisproduk()
    {
        return $this->belongsTo(ProdukSubJenis::class, 'sub_jenis_id');
    }

    public function produkstatus()
    {
        return $this->belongsTo(ProdukStatus::class, 'jenis_id');
    }

    public function recapstatus()
    {
        return $this->belongsTo(KiosRecapStatus::class, 'status_id');
    }

    public function keperluan()
    {
        return $this->belongsTo(KiosRecapKeperluan::class, 'keperluan_id');
    }

}
