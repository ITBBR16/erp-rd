<?php

namespace App\Models\kios;

use App\Models\customer\Customer;
use App\Models\employee\Employee;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KiosTransaksi extends Model
{
    use HasFactory;

    protected $connection = 'rumahdrone_kios';
    protected $table = 'kios_transaksi';
    protected $guarded = ['id'];

    public function metodepembayaran()
    {
        return $this->belongsTo(KiosAkunRD::class, 'metode_pembayaran');
    }

    public function detailtransaksi()
    {
        return $this->hasMany(KiosTransaksiDetail::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function transaksidp()
    {
        return $this->hasOne(KiosTransaksiDPPO::class);
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    public function transaksiPart()
    {
        return $this->hasMany(KiosTransaksiPart::class);
    }
}
