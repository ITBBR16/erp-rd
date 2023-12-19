<?php

namespace App\Models\kios;

use App\Models\kios\KiosOrder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KiosHistoryOrderList extends Model
{
    use HasFactory;

    protected $connection = 'rumahdrone_kios';
    protected $table = 'history_order';
    protected $guarded = ['id'];

    public function order()
    {
        return $this->belongsTo(KiosOrder::class);
    }
}
