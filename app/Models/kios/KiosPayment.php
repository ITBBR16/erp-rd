<?php

namespace App\Models\kios;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KiosPayment extends Model
{
    use HasFactory;

    protected $connection = 'rumahdrone_kios';
    protected $table = 'kios_payment';
    protected $guarded = ['id'];

    public function order()
    {
        return $this->belongsTo(KiosOrder::class);
    }
}
