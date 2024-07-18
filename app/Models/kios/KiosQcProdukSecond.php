<?php

namespace App\Models\kios;

use App\Models\kios\KiosOrderSecond;
use Illuminate\Database\Eloquent\Model;
use App\Models\produk\ProdukKelengkapan;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KiosQcProdukSecond extends Model
{
    use HasFactory;

    protected $connection = 'rumahdrone_kios';
    protected $table = 'kios_qc_produk_second';
    protected $guarded = ['pivot_qc_id'];

    public function kelengkapans() {
        return $this->belongsToMany(ProdukKelengkapan::class, 'kios_kelengkapan_second_list', 'qc_id', 'produk_kelengkapan_id')
                    ->withPivot('pivot_qc_id', 'kios_produk_second_id', 'kondisi', 'keterangan', 'serial_number', 'harga_satuan', 'status');
    }

    public function ordersecond()
    {
        return $this->belongsTo(KiosOrderSecond::class, 'order_second_list');
    }

}
