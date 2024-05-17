<?php

namespace App\Models\kios;

use App\Models\ekspedisi\ValidasiProduk;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KiosKomplainSupplier extends Model
{
    use HasFactory;

    protected $connection = 'rumahdrone_kios';
    protected $table = 'kios_supplier_komplain';
    protected $guarded = ['id'];

    public function validasi()
    {
        return $this->belongsTo(ValidasiProduk::class, 'validasi_id');
    }

    public function orderlists()
    {
        return $this->belongsTo(KiosOrderList::class, 'order_list_id');
    }

}
