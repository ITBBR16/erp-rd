<?php

namespace App\Models\kios;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KiosStatusPembayaran extends Model
{
    use HasFactory;

    protected $connection = 'rumahdrone_kios';
    protected $table = 'status_pembayaran';
    protected $guarded = ['id'];

    public function ordersecond()
    {
        return $this->hasMany(KiosOrderSecond::class);
    }

}
