<?php

namespace App\Models\repair;

use App\Models\customer\Customer;
use App\Models\employee\Employee;
use App\Models\produk\ProdukJenis;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RepairCase extends Model
{
    use HasFactory;

    protected $connection = 'rumahdrone_repair';
    protected $table = 'repair_case';
    protected $guarded = ['id'];

    //relasi terhadap subjenis belum dibuatkan
    
    public function produkJenis()
    {
        return $this->belongsTo(ProdukJenis::class, 'produk_jenis_id');
    }
    
    public function jenisFungsional()
    {
        return $this->belongsTo(RepairJenisFungsional::class, 'jenis_fungsional_id');
    }

    public function jenisStatus()
    {
        return $this->belongsTo(RepairJenisStatus::class, 'jenis_status_id');
    }

    public function jenisCase()
    {
        return $this->belongsTo(RepairJenisCase::class, 'jenis_case_id');
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function teknisi()
    {
        return $this->belongsTo(Employee::class, 'teknisi_id');
    }

    public function kelengkapan()
    {
        return $this->hasMany(RepairKelengkapan::class);
    }

    public function estimasi()
    {
        return $this->hasMany(RepairEstimasi::class);
    }

    public function transaksi()
    {
        return $this->hasOne(RepairTransaksi::class);
    }

    public function timestampStatus()
    {
        return $this->hasMany(RepairCase::class);
    }

    public function requestPart()
    {
        return $this->hasMany(RepairRequestPart::class);
    }
}
