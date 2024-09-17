<?php

namespace App\Models\ekspedisi;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogPenerima extends Model
{
    use HasFactory;

    protected $connection = 'rumahdrone_ekspedisi';
    protected $table = 'log_penerima';
    protected $guarded = ['id'];

    public function logRequest()
    {
        return $this->hasOne(LogRequest::class);
    }
}
