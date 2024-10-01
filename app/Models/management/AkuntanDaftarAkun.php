<?php

namespace App\Models\management;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AkuntanDaftarAkun extends Model
{
    use HasFactory;

    protected $connection = 'rumahdrone_management';
    protected $table = 'akuntan_daftar_akun';
    protected $guarded = ['id'];

    public function mutasiAkuntan()
    {
        return $this->hasMany(AkuntanMutasi::class, 'akun_id');
    }

    public function mutasiMonth()
    {
        return $this->hasMany(AkuntanMutasiMonth::class, 'akun_id');
    }
}
