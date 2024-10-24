<?php

namespace App\Models\gudang;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GudangSupplier extends Model
{
    use HasFactory;

    protected $connection = 'rumahdrone_gudang';
    protected $table = 'gudang_supplier';
    protected $guarded = ['id'];

    public function gudangBelanja()
    {
        return $this->hasMany(GudangBelanja::class);
    }

    public function metodePembayaran()
    {
        return $this->hasMany(GudangMetodePembayaran::class);
    }
}
