<?php

namespace App\Models\produk;

use App\Models\kios\KiosProduk;
use App\Models\kios\SupplierKios;
use App\Models\kios\KiosOrderList;
use App\Models\kios\KiosDailyRecap;
use App\Models\kios\KiosImageProduk;
use App\Models\kios\KiosImageSecond;
use App\Models\kios\KiosOrderSecond;
use App\Models\kios\KiosProdukSecond;
use App\Models\kios\KiosWTB;
use App\Models\kios\KiosWTS;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProdukSubJenis extends Model
{
    use HasFactory;

    protected $connection = 'rumahdrone_produk';
    protected $table = 'produk_sub_jenis';
    protected $guarded = ['id'];

    public function kelengkapans(){
        return $this->belongsToMany(ProdukKelengkapan::class, 'produk_sub_kelengkapan')
                    ->withPivot('quantity');
    }

    public function produkjenis()
    {
        return $this->belongsTo(ProdukJenis::class, 'jenis_id');
    }

    public function orderLists()
    {
        return $this->hasMany(KiosOrderList::class);
    }

    public function suppliers()
    {
        return $this->belongsToMany(SupplierKios::class, 'supplier_kios_sub', 'sub_jenis_id', 'supplier_kios_id');
    }

    public function ordersecond()
    {
        return $this->hasMany(KiosOrderSecond::class);
    }

    public function kiosproduk()
    {
        return $this->hasMany(KiosProduk::class, 'sub_jenis_id');
    }

    public function kiosproduksecond()
    {
        return $this->hasMany(KiosProdukSecond::class, 'sub_jenis_id');
    }

    public function produktype()
    {
        return $this->belongsTo(ProdukType::class, 'produk_type_id');
    }

    public function dialyrecap()
    {
        return $this->hasMany(KiosDailyRecap::class);
    }

    public function imagekiosbaru()
    {
        return $this->hasMany(KiosImageProduk::class);
    }
    
    public function imagekiossecond()
    {
        return $this->hasMany(KiosImageSecond::class);
    }

    public function kiosRecapWtb()
    {
        return $this->hasMany(KiosWTB::class);
    }

    public function kiosRecapWts()
    {
        return $this->hasMany(KiosWTS::class);
    }

}
