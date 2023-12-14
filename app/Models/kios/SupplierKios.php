<?php

namespace App\Models\kios;

use App\Models\produk\ProdukKategori;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplierKios extends Model
{
    use HasFactory;

    protected $connection = 'rumahdrone_kios';
    protected $table = 'supplier_kios';
    protected $guarded = ['id'];

    public function kategoris()
    {
        return $this->belongsToMany(ProdukKategori::class, 'supplier_kios_kategori', 'supplier_kios_id', 'produk_kategori_id');
    }

}
