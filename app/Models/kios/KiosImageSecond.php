<?php

namespace App\Models\kios;

use App\Models\produk\ProdukSubJenis;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KiosImageSecond extends Model
{
    use HasFactory;

    protected $connection = 'rumahdrone_kios';
    protected $table = 'kios_image_paket_baru';
    protected $guarded = ['id'];

    public function subjenis()
    {
        return $this->belongsTo(ProdukSubJenis::class, 'sub_jenis_id');
    }

    public function produkbarukios()
    {
        return $this->belongsTo(KiosProdukSecond::class, 'id');
    }
    
}
