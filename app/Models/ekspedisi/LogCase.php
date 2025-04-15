<?php

namespace App\Models\ekspedisi;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogCase extends Model
{
    use HasFactory;

    protected $connection = 'rumahdrone_ekspedisi';
    protected $table = 'log_case';
    protected $guarded = ['id'];

    public function logRequest()
    {
        return $this->hasOne(LogRequest::class, 'source_id')->where('divisi_id', 6);
    }
}
