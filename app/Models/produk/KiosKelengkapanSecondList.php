<?php

namespace App\Models\produk;

use App\Models\kios\KiosQcProdukSecond;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KiosKelengkapanSecondList extends Model
{
    use HasFactory;

    protected $connection = 'rumahdrone_produk';
    protected $table = 'kios_kelengkapan_second_list';
    protected $guarded = ['id'];

    public function kiosQCSecond()
    {
        return $this->belongsTo(KiosQcProdukSecond::class, 'qc_id');
    }

    public function kelengkapans()
    {
        return $this->belongsTo(ProdukKelengkapan::class, 'produk_kelengkapan_id');
    }

}
