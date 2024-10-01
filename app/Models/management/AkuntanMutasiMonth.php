<?php

namespace App\Models\management;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AkuntanMutasiMonth extends Model
{
    use HasFactory;

    protected $connection = 'rumahdrone_management';
    protected $table = 'akuntan_mutasi_month';
    protected $guarded = ['id'];

    public function namaAkun()
    {
        return $this->belongsTo(AkuntanDaftarAkun::class, 'akun_id');
    }

    public function documentSementara()
    {
        return $this->hasOne(AkuntanDocumentMonth::class, 'table_id');
    }
}
