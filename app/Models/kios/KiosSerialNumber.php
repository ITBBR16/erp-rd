<?php

namespace App\Models\kios;

use App\Models\ekspedisi\ValidasiProduk;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KiosSerialNumber extends Model
{
    use HasFactory;

    protected $connection = 'rumahdrone_kios';
    protected $table = 'serial_number';
    protected $guarded = ['id'];

    public function kiosproduk()
    {
        return $this->belongsTo(KiosProduk::class, 'produk_id');
    }

    public function validasiproduk()
    {
        return $this->belongsTo(ValidasiProduk::class, 'validasi_id');
    }

    public function transaksidetails()
    {
        return $this->hasOne(KiosTransaksiDetail::class);
    }

    public function listKelengkapanSplit()
    {
        return $this->hasMany(KiosListKelengkapanSplit::class);
    }

}
