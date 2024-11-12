<?php

namespace App\Models\gudang;

use App\Models\employee\Employee;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GudangBelanja extends Model
{
    use HasFactory;

    protected $connection = 'rumahdrone_gudang';
    protected $table = 'gudang_belanja';
    protected $guarded = ['id'];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    public function gudangSupplier()
    {
        return $this->belongsTo(GudangSupplier::class);
    }

    public function detailBelanja()
    {
        return $this->hasMany(GudangBelanjaDetail::class);
    }

    public function gudangPengiriman()
    {
        return $this->hasMany(GudangPengiriman::class);
    }

    public function requestPembayaran()
    {
        return $this->hasMany(GudangRequestPembayaran::class);
    }
    
    public function gudangMetodePembayaran()
    {
        return $this->belongsTo(GudangMetodePembayaran::class);
    }

    public function gudangUnboxing()
    {
        return $this->hasMany(GudangUnboxing::class);
    }

    public function gudangProdukIdItem()
    {
        return $this->hasMany(GudangProdukIdItem::class);
    }
}
