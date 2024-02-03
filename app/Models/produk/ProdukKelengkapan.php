<?php

namespace App\Models\produk;

use App\Models\kios\KiosQcProdukSecond;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProdukKelengkapan extends Model
{
    use HasFactory;

    protected $connection = 'rumahdrone_produk';
    protected $table = 'produk_kelengkapan';
    protected $guarded = ['id'];

    public function subJenis(){
        return $this->belongsToMany(ProdukSubJenis::class, 'produk_sub_kelengkapan');
    }

    public function qcprodukseconds() {
        return $this->belongsToMany(KiosQcProdukSecond::class, 'kios_kelengkapan_second_list', 'produk_kelengkapan_id', 'qc_id')
                    ->withPivot('pivot_qc_id', 'kondisi', 'keterangan', 'serial_number', 'harga_satuan', 'status');
    }
}
