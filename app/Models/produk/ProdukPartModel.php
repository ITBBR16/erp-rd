<?php

namespace App\Models\produk;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProdukPartModel extends Model
{
    use HasFactory;

    protected $connection = 'rumahdrone_produk';
    protected $table = 'produk_part_model';
    protected $guarded = ['id'];

    public function spareparts()
    {
        return $this->hasMany(ProdukSparepart::class);
    }
}
