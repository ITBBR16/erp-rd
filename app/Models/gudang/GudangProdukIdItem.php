<?php

namespace App\Models\gudang;

use App\Models\kios\KiosTransaksiPart;
use App\Models\produk\ProdukSparepart;
use Illuminate\Database\Eloquent\Model;
use App\Models\repair\RepairEstimasiPart;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GudangProdukIdItem extends Model
{
    use HasFactory;

    protected $connection = 'rumahdrone_gudang';
    protected $table = 'gudang_produk_id_item';
    protected $guarded = ['id'];

    public function gudangBelanja()
    {
        return $this->belongsTo(GudangBelanja::class, 'gudang_belanja_id');
    }

    public function gudangProduk() // Salah
    {
        return $this->belongsTo(GudangProduk::class, 'gudang_produk_id');
    }

    public function qualityControll()
    {
        return $this->hasOne(GudangQualityControll::class);
    }

    public function historyPart()
    {
        return $this->hasOne(GudangHistoryPart::class);
    }

    public function historySplit()
    {
        return $this->hasOne(GudangHistorySplit::class);
    }

    public function gudangAdjustStock()
    {
        return $this->hasOne(GudangAdjustStock::class);
    }

    public function estimasiRepair()
    {
        return $this->hasOne(RepairEstimasiPart::class);
    }

    public function produkSparepart()
    {
        return $this->belongsTo(ProdukSparepart::class, 'gudang_produk_id');
    }

    public function transaksiKios()
    {
        return $this->hasOne(KiosTransaksiPart::class);
    }

}
