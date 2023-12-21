<?php

namespace App\Models\kios;

use App\Models\produk\ProdukKategori;
use App\Models\produk\ProdukSubJenis;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    public function orders()
    {
        return $this->hasMany(KiosOrder::class, 'supplier_kios_id');
    }

    public function subjenis()
    {
        return $this->belongsToMany(ProdukSubJenis::class, 'supplier_kios_sub', 'supplier_kios_id', 'sub_jenis_id');
    }

}
