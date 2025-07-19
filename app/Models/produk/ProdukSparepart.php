<?php

namespace App\Models\produk;

use App\Models\gudang\GudangProduk;
use App\Models\kios\KiosTransaksiPart;
use Illuminate\Database\Eloquent\Model;
use App\Models\gudang\GudangProdukIdItem;
use App\Models\gudang\GudangBelanjaDetail;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProdukSparepart extends Model
{
    use HasFactory;

    protected $connection = 'rumahdrone_produk';
    protected $table = 'produk_sparepart';
    protected $guarded = ['id'];

    public function produkType()
    {
        return $this->belongsTo(ProdukType::class, 'produk_type_id');
    }

    public function partModel()
    {
        return $this->belongsTo(ProdukPartModel::class, 'produk_part_model_id');
    }

    public function produkJenis()
    {
        return $this->belongsTo(ProdukJenis::class, 'produk_jenis_id');
    }

    public function partBagian()
    {
        return $this->belongsTo(ProdukPartBagian::class, 'produk_part_bagian_id');
    }

    public function partSubBagian()
    {
        return $this->belongsTo(ProdukPartSubBagian::class, 'produk_part_sub_bagian_id');
    }

    public function partSifat() // Dipakek apa engga ya
    {
        return $this->belongsTo(ProdukPartSifat::class, 'produk_part_sifat_id');
    }

    public function detailBelanja()
    {
        return $this->hasMany(GudangBelanjaDetail::class, 'sparepart_id');
    }

    public function gudangProduk()
    {
        return $this->hasOne(GudangProduk::class);
    }

    public function gudangIdItem()
    {
        return $this->hasMany(GudangProdukIdItem::class, 'gudang_produk_id');
    }

    public function transaksiPart()
    {
        return $this->hasMany(KiosTransaksiPart::class, 'gudang_produk_id');
    }
}
