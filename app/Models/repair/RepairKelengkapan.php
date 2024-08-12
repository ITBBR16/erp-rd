<?php

namespace App\Models\repair;

use App\Models\produk\ProdukKelengkapan;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RepairKelengkapan extends Model
{
    use HasFactory;

    protected $connection = 'rumahdrone_repair';
    protected $table = 'repair_kelengkapan';
    protected $guarded = ['id'];

    public function case()
    {
        return $this->belongsTo(RepairCase::class, 'case_id');
    }

    public function itemKelengkapan()
    {
        return $this->belongsTo(ProdukKelengkapan::class, 'item_kelengkapan_id');
    }

}
