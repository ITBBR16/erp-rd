<?php

namespace App\Models\kios;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KiosHistorySupportSupplier extends Model
{
    use HasFactory;

    protected $connection = 'rumahdrone_kios';
    protected $table = 'supplier_support_history';
    protected $guarded = ['id'];

    public function supplierKios()
    {
        return $this->belongsTo(SupplierKios::class, 'supplier_id');
    }

    public function produkKios()
    {
        return $this->belongsTo(KiosProduk::class, 'product_id');
    }

}
