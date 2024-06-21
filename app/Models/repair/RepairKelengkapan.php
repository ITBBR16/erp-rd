<?php

namespace App\Models\repair;

use App\Models\produk\ProdukKelengkapan;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RepairKelengkapan extends Model
{
    use HasFactory;

    public function case()
    {
        return $this->belongsTo(RepairCase::class, 'case_id');
    }

    public function itemKelengkapan()
    {
        return $this->belongsTo(ProdukKelengkapan::class, 'kelengkapan_id');
    }

}
