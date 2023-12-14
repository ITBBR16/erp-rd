<?php

namespace App\Models\produk;

use App\Models\kios\SupplierKios;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProdukKategori extends Model
{
    use HasFactory;

    protected $connection = 'rumahdrone_produk';
    protected $table = 'produk_kategori';
    protected $guarded = ['id'];

    public function supplier()
    {
        return $this->belongsToMany(SupplierKios::class, 'supplier_kios_kategori', 'produk_kategori_id', 'supplier_kios_id');
    }
}
