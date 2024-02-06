<?php

namespace App\Models\kios;

use App\Models\customer\Customer;
use App\Models\ekspedisi\PengirimanEkspedisi;
use App\Models\produk\ProdukSubJenis;
use App\Models\kios\KiosQcProdukSecond;
use Illuminate\Database\Eloquent\Model;
use App\Models\kios\KiosMetodePembelianSecond;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KiosOrderSecond extends Model
{
    use HasFactory;

    protected $connection = 'rumahdrone_kios';
    protected $table = 'order_second';
    protected $guarded = ['id'];

    public function buymetodesecond()
    {
        return $this->belongsTo(KiosMetodePembelianSecond::class, 'metode_pembelian_id');
    }

    public function marketplace()
    {
        return $this->belongsTo(KiosMarketplace::class, 'asal_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function subjenis()
    {
        return $this->belongsTo(ProdukSubJenis::class, 'sub_jenis_id');
    }

    public function statuspembayaran()
    {
        return $this->belongsTo(KiosStatusPembayaran::class, 'status_pembayaran_id');
    }

    public function qcsecond()
    {
        return $this->hasOne(KiosQcProdukSecond::class, 'order_second_id');
    }

    public function pengiriman()
    {
        return $this->hasMany(PengirimanEkspedisi::class);
    }

}
