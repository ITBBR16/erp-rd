<?php

namespace App\Models\gudang;

use App\Models\management\AkuntanAkunBank;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GudangMetodePembayaran extends Model
{
    use HasFactory;

    protected $connection = 'rumahdrone_gudang';
    protected $table = 'gudang_metode_pembayaran';
    protected $guarded = ['id'];

    public function belanja()
    {
        return $this->hasMany(GudangBelanja::class);
    }

    public function namaBank()
    {
        return $this->belongsTo(AkuntanAkunBank::class, 'nama_bank_id');
    }
}
