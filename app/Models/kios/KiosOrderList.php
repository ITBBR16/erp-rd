<?php

namespace App\Models\kios;

use App\Models\produk\ProdukSubJenis;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KiosOrderList extends Model
{
    use HasFactory;

    protected $connection = 'rumahdrone_kios';
    protected $table = 'order_list';
    protected $guarded = ['id'];

    public function order()
    {
        return $this->belongsTo(KiosOrder::class);
    }

    public function paket()
    {
        return $this->belongsTo(ProdukSubJenis::class);
    }

}
