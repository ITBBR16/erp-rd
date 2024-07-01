<?php

namespace App\Models\kios;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KiosRecapTechnicalSupport extends Model
{
    use HasFactory;

    protected $connection = 'rumahdrone_kios';
    protected $table = 'kios_recap_ts';
    protected $guarded = ['id'];

    public function technicalSupport()
    {
        return $this->belongsTo(KiosTechnicalSupport::class, 'kios_ts_id');
    }

    public function kiosDR()
    {
        return $this->hasOne(KiosDailyRecap::class);
    }
}
