<?php

namespace App\Models\kios;

use App\Models\customer\Customer;
use App\Models\employee\Employee;
use App\Models\produk\ProdukJenis;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KiosDailyRecap extends Model
{
    use HasFactory;

    protected $connection = 'rumahdrone_kios';
    protected $table = 'daily_recap';
    protected $guarded = ['id'];

    public function permasalahanproduk()
    {
        return $this->belongsToMany(ProdukJenis::class, 'permasalahan_produk', 'permasalahan_id', 'jenis_id');
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function produkjenis()
    {
        return $this->belongsTo(ProdukJenis::class, 'jenis_produk_id');
    }

    public function keperluan()
    {
        return $this->belongsTo(KiosRecapKeperluan::class, 'keperluan_id');
    }

    public function kategoripermasalahan()
    {
        return $this->belongsTo(KiosKategoriPermasalahan::class, 'kategori_permasalahan_id');
    }

    public function recapTs()
    {
        return $this->belongsTo(KiosRecapTechnicalSupport::class, 'table_id');
    }

    public function kiosWtb()
    {
        return $this->belongsTo(KiosWTB::class, 'table_id');
    }

    public function kiosWts()
    {
        return $this->belongsTo(KiosWTS::class, 'table_id');
    }

}
