<?php

namespace App\Models\repair;

use App\Models\gudang\GudangProduk;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RepairEstimasiPart extends Model
{
    use HasFactory;

    protected $connection = 'rumahdrone_repair';
    protected $table = 'repair_estimasi_part';
    protected $guarded = ['id'];

    public function estimasi()
    {
        return $this->belongsTo(RepairEstimasi::class, 'estimasi_id');
    }

    public function jenisTransaksi()
    {
        return $this->belongsTo(RepairJenisTransaksi::class, 'jenis_transaksi_id');
    }

    public function sparepartGudang()
    {
        return $this->belongsTo(GudangProduk::class, 'gudang_produk_id');
    }

}
