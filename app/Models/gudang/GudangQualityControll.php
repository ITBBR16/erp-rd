<?php

namespace App\Models\gudang;

use App\Models\employee\Employee;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GudangQualityControll extends Model
{
    use HasFactory;

    protected $connection = 'rumahdrone_gudang';
    protected $table = 'gudang_quality_controll';
    protected $guarded = ['id'];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    public function gudangProdukIdItem()
    {
        return $this->belongsTo(GudangProdukIdItem::class, 'gudang_produk_id_item_id');
    }

    public function gudangKomplain()
    {
        return $this->hasOne(GudangKomplain::class);
    }

}
