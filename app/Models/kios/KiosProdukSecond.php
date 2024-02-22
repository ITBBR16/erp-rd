<?php

namespace App\Models\kios;

use App\Models\produk\ProdukKelengkapan;
use App\Models\produk\ProdukSubJenis;
use Illuminate\Database\Eloquent\Model;
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

    public function qcProukSeconds()
    {
        return $this->belongsToMany(KiosQcProdukSecond::class, 'kios_kelengkapan_second_list', 'kios_produk_second_id', 'qc_id')->withPivot('produk_kelengkapan_id');
    }

    public function kelengkapanSeconds()
    {
        return $this->belongsToMany(ProdukKelengkapan::class, 'kios_kelengkapan_second_list', 'kios_produk_second_id', 'produk_kelengkapan_id')->withPivot('qc_id');
    }

    public function imageprodukbaru()
    {
        return $this->belongsTo(KiosImageSecond::class, 'produk_image_id');
    }

}
