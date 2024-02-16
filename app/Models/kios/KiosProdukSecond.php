<?php

namespace App\Models\kios;

use App\Models\produk\ProdukSubJenis;
use App\Models\kios\KiosQcProdukSecond;
use Illuminate\Database\Eloquent\Model;
use App\Models\produk\ProdukKelengkapan;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KiosProdukSecond extends Model
{
    use HasFactory;

    protected $connection = 'rumahdrone_kios';
    protected $table = 'kios_produk_second';
    protected $guarded = ['id'];

    public function subjenis()
    {
        return $this->belongsTo(ProdukSubJenis::class, 'sub_jenis_id');
    }

    public function produksecondlist()
    {
        return $this->belongsToMany(ProdukKelengkapan::class, 'kios_kelengkapan_second_list', 'kios_produk_second_id', 'produk_kelengkapan_id');
    }
}
