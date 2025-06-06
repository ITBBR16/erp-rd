<?php

namespace App\Models\customer;

use App\Models\wilayah\Kota;
use App\Models\wilayah\Provinsi;
use App\Models\ekspedisi\LogCase;
use App\Models\repair\RepairCase;
use App\Models\wilayah\Kecamatan;
use App\Models\wilayah\Kelurahan;
use App\Models\kios\KiosTransaksi;
use App\Models\kios\KiosDailyRecap;
use App\Models\ekspedisi\LogRequest;
use App\Models\kios\KiosOrderSecond;
use App\Models\repair\RepairTransaksi;
use Illuminate\Database\Eloquent\Model;
use App\Models\repair\RepairReviewCustomer;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Customer extends Model
{
    use HasFactory;

    protected $connection = 'rumahdrone_customer';
    protected $table = 'customer';
    protected $guarded = ['id'];

    public function provinsi()
    {
        return $this->belongsTo(Provinsi::class, 'provinsi_id');
    }

    public function kota()
    {
        return $this->belongsTo(Kota::class, 'kota_kabupaten_id');
    }

    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class, 'kecamatan_id');
    }

    public function kelurahan()
    {
        return $this->belongsTo(Kelurahan::class, 'kelurahan_id');
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

    public function customerReviewRepair()
    {
        return $this->hasMany(RepairReviewCustomer::class);
    }

    public function logRequest()
    {
        return $this->hasMany(LogRequest::class);
    }

    public function logCase()
    {
        return $this->hasMany(LogCase::class, 'penerima_id');
    }
}
