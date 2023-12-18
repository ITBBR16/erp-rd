<?php

namespace App\Models\kios;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KiosHistoryOrderList extends Model
{
    use HasFactory;

    protected $connection = 'rumahdrone_kios';
    protected $table = 'history_order';
    protected $guarded = ['id'];
}
