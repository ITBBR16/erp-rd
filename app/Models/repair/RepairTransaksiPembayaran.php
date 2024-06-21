<?php

namespace App\Models\repair;

use App\Models\kios\KiosAkunRD;
use App\Models\employee\Employee;
use App\Models\repair\RepairTransaksi;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RepairTransaksiPembayaran extends Model
{
    use HasFactory;

    public function transaksi()
    {
        return $this->belongsTo(RepairTransaksi::class, 'transaksi_id');
    }

    public function metodePembayaran()
    {
        return $this->belongsTo(KiosAkunRD::class, 'metode_pembayaran_id');
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }
}
