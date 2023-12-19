<?php

namespace App\Models\kios;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KiosOrder extends Model
{
    use HasFactory;

    protected $connection = 'rumahdrone_kios';
    protected $table = 'order';
    protected $guarded = ['id'];

    public function supplier()
    {
        return $this->belongsTo(SupplierKios::class, 'id');
    }

    public function orderLists()
    {
        return $this->hasMany(KiosOrderList::class, 'order_id');
    }

    public function histories()
    {
        return $this->hasMany(KiosHistoryOrderList::class);
    }
}
