<?php

namespace App\Models\kios;

use App\Models\gudang\GudangProdukIdItem;
use App\Models\produk\ProdukSparepart;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KiosTransaksiPart extends Model
{
    use HasFactory;

    protected $connection = 'rumahdrone_kios';
    protected $table = 'kios_transaksi_part';
    protected $guarded = ['id'];

    public function transaksiKios()
    {
        return $this->belongsTo(KiosTransaksi::class, 'transaksi_id');
    }

    public function sparepart()
    {
        return $this->belongsTo(ProdukSparepart::class, 'gudang_produk_id');
    }

    public function gudangIdItem()
    {
        return $this->belongsTo(GudangProdukIdItem::class, 'gudang_id_item_id');
    }
}
