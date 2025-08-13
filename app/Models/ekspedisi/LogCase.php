<?php

namespace App\Models\ekspedisi;

use App\Models\customer\Customer;
use App\Models\divisi\Divisi;
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

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'penerima_id');
    }

    public function logPenerima()
    {
        return $this->belongsTo(LogPenerima::class, 'penerima_id');
    }

    public function divisi()
    {
        return $this->belongsTo(Divisi::class, 'asal_divisi_id');
    }
}
