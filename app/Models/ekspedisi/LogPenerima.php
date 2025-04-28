<?php

namespace App\Models\ekspedisi;

use App\Models\wilayah\Kota;
use App\Models\wilayah\Provinsi;
use App\Models\ekspedisi\LogCase;
use App\Models\wilayah\Kecamatan;
use App\Models\wilayah\Kelurahan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LogPenerima extends Model
{
    use HasFactory;

    protected $connection = 'rumahdrone_ekspedisi';
    protected $table = 'log_penerima';
    protected $guarded = ['id'];

    public function logCase()
    {
        return $this->hasOne(LogCase::class, 'penerima_id');
    }

    public function logRequest()
    {
        return $this->hasOne(LogRequest::class, 'penerima_id');
    }

    public function provinsi()
    {
        return $this->belongsTo(Provinsi::class, 'provinsi_id');
    }

    public function kota()
    {
        return $this->belongsTo(Kota::class, 'kabupaten_kota_id');
    }

    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class, 'kecamatan_id');
    }

    public function kelurahan()
    {
        return $this->belongsTo(Kelurahan::class, 'kelurahan_id');
    }

}
