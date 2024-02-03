<?php

namespace App\Models\kios;

use App\Models\produk\ProdukSubJenis;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KiosProduk extends Model
{
    use HasFactory;

    protected $connection = 'rumahdrone_kios';
    protected $table = 'kios_produk';
    protected $guarded = ['id'];

    public function subjenis()
    {
        return $this->belongsTo(ProdukSubJenis::class, 'sub_jenis_id');
    }

    public function serialnumber()
    {
        return $this->hasMany(KiosSerialNumber::class);
    }

}
