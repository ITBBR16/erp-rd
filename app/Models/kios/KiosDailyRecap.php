<?php

namespace App\Models\kios;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KiosDailyRecap extends Model
{
    use HasFactory;

    protected $connection = 'rumahdrone_kios';
    protected $table = 'daily_recap';
    protected $guarded = ['id'];
}
