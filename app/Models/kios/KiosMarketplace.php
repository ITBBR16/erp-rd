<?php

namespace App\Models\kios;

use App\Models\kios\KiosOrderSecond;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KiosMarketplace extends Model
{
    use HasFactory;

    protected $connection = 'rumahdrone_kios';
    protected $table = 'kios_marketplace';
    protected $guarded = ['id'];

    public function ordersecond()
    {
        return $this->hasMany(KiosOrderSecond::class);
    }
}
