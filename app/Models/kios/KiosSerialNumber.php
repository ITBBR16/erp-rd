<?php

namespace App\Models\kios;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KiosSerialNumber extends Model
{
    use HasFactory;

    protected $connection = 'rumahdrone_kios';
    protected $table = 'serial_number';
    protected $guarded = ['id'];
}
