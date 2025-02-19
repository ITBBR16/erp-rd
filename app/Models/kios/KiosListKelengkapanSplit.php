<?php

namespace App\Models\kios;

use App\Models\produk\ProdukKelengkapan;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KiosListKelengkapanSplit extends Model
{
    use HasFactory;

    protected $connection = 'rumahdrone_kios';
    protected $table = 'kios_list_kelengkapan_split';
    protected $guarded = ['id'];

    public function produkBnob()
    {
        return $this->belongsTo(KiosProdukBnob::class, 'kios_produk_bnob_id');
    }

    public function serialNumberAwal()
    {
        return $this->belongsTo(KiosSerialNumber::class, 'serial_number_id');
    }

    public function kelengkapanProduk()
    {
        return $this->belongsTo(ProdukKelengkapan::class, 'produk_kelengkapan_id');
    }
}
