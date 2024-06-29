<?php

namespace App\Models\kios;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KiosWTS extends Model
{
    use HasFactory;

    protected $connection = 'rumahdrone_kios';
    protected $table = 'kios_want_to_sell';
    protected $guarded = ['id'];

    public function kiosDR()
    {
        return $this->hasOne(KiosDailyRecap::class);
    }

}
