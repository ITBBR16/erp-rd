<?php

namespace App\Models\customer;

use App\Models\kios\KiosDailyRecap;
use App\Models\kios\KiosOrderSecond;
use App\Models\kios\KiosTransaksi;
use App\Models\repair\RepairCase;
use App\Models\repair\RepairTransaksi;
use App\Models\wilayah\Provinsi;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $connection = 'rumahdrone_customer';
    protected $table = 'customer';
    protected $guarded = ['id'];

    public function provinsi()
    {
        return $this->belongsTo(Provinsi::class, 'provinsi');
    }

    public function suppliersecond()
    {
        return $this->hasMany(KiosOrderSecond::class);
    }

    public function dailyrecap()
    {
        return $this->hasMany(KiosDailyRecap::class);
    }

    public function transaksiKios()
    {
        return $this->hasMany(KiosTransaksi::class);
    }

    public function infoperusahaan()
    {
        return $this->belongsTo(CustomerInfoPerusahaan::class);
    }

    public function repairCase()
    {
        return $this->hasMany(RepairCase::class);
    }

    public function repairTransaksi()
    {
        return $this->hasMany(RepairTransaksi::class);
    }
}
