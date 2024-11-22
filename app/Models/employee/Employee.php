<?php

namespace App\Models\employee;

use App\Models\ekspedisi\LogRequest;
use App\Models\gudang\GudangAdjustStock;
use App\Models\gudang\GudangBelanja;
use App\Models\gudang\GudangQualityControll;
use App\Models\gudang\GudangUnboxing;
use App\Models\gudang\GudangValidasi;
use App\Models\kios\KiosDailyRecap;
use App\Models\kios\KiosTransaksi;
use App\Models\repair\RepairCase;
use App\Models\repair\RepairEstimasi;
use App\Models\repair\RepairJurnal;
use App\Models\repair\RepairTransaksiPembayaran;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $connection = 'rumahdrone_employee';
    protected $table = 'employee';
    protected $guarded = ['id'];

    public function dailyrecap()
    {
        return $this->hasMany(KiosDailyRecap::class);
    }

    public function transaksikios()
    {
        return $this->hasMany(KiosTransaksi::class);
    }

    public function repairCase()
    {
        return $this->hasMany(RepairCase::class);
    }

    public function repairJurnal()
    {
        return $this->hasMany(RepairJurnal::class);
    }

    public function repairEstimasi()
    {
        return $this->hasMany(RepairEstimasi::class);
    }

    public function repairTransaksiPembayaran()
    {
        return $this->hasMany(RepairTransaksiPembayaran::class);
    }

    public function logRequest()
    {
        return $this->hasMany(LogRequest::class, 'employee_id');
    }

    public function gudangBelanja()
    {
        return $this->hasMany(GudangBelanja::class);
    }

    public function gudangUnboxing()
    {
        return $this->hasMany(GudangUnboxing::class);
    }

    public function gudangQC()
    {
        return $this->hasMany(GudangQualityControll::class);
    }

    public function gudangAdjustStock()
    {
        return $this->hasMany(GudangAdjustStock::class);
    }

}
