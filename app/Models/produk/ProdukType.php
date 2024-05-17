<?php

namespace App\Models\produk;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProdukType extends Model
{
    use HasFactory;

    protected $connection = 'rumahdrone_produk';
    protected $table = 'produk_type';
    protected $guarded = ['id'];

    public function subjenis()
    {
        return $this->hasMany(ProdukSubJenis::class);
    }

}
