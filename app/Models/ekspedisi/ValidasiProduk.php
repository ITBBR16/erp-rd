<?php

namespace App\Models\ekspedisi;

use App\Models\kios\KiosOrderList;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ValidasiProduk extends Model
{
    use HasFactory;

    protected $connection = 'rumahdrone_ekspedisi';
    protected $table = 'validasi_barang';
    protected $guarded = ['id'];

    public function orderLists()
    {
        return $this->belongsTo(KiosOrderList::class);
    }

}
