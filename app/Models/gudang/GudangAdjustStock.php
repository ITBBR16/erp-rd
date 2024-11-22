<?php

namespace App\Models\gudang;

use App\Models\employee\Employee;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GudangAdjustStock extends Model
{
    use HasFactory;

    protected $connection = 'rumahdrone_gudang';
    protected $table = 'gudang_adjust_stok';
    protected $guarded = ['id'];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    public function idItemGudang()
    {
        return $this->belongsTo(GudangProdukIdItem::class, 'gudang_produk_id_item_id');
    }

}
