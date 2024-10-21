<?php

namespace App\Models\repair;

use App\Models\customer\Customer;
use App\Models\employee\Employee;
use App\Models\repair\RepairCase;
use Illuminate\Database\Eloquent\Model;
use App\Models\management\AkuntanMutasi;
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

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function transaksiPembayaran()
    {
        return $this->hasMany(RepairTransaksiPembayaran::class, 'transaksi_id');
    }

    public function mergeMutasiTransaksi()
    {
        return $this->belongsToMany(AkuntanMutasi::class, 'rumahdrone_management.akuntan_pencocokan', 'transaksi_id', 'mutasi_id')
                    ->withPivot(['status_penjurnalan', 'catatan']);
    }

}
