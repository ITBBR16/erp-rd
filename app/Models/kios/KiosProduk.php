<?php

namespace App\Models\kios;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KiosProduk extends Model
{
    use HasFactory;

    protected $connection = 'rumahdrone_kios';
    protected $table = 'kios_produk';
    protected $guarded = ['id'];
}
