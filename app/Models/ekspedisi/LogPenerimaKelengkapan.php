<?php

namespace App\Models\ekspedisi;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogPenerimaKelengkapan extends Model
{
    use HasFactory;

    protected $connection = 'rumahdrone_ekspedisi';
    protected $table = 'log_penerima_kelengkapan';
    protected $guarded = ['id'];

}
