<?php

namespace App\Models\kios;

use Illuminate\Database\Eloquent\Model;
use App\Models\management\AkuntanAkunBank;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KiosMetodePembayaranSecond extends Model
{
    use HasFactory;

    protected $connection = 'rumahdrone_kios';
    protected $table = 'kios_metode_pembayaran_second';
    protected $guarded = ['id'];

    public function payment()
    {
        return $this->hasMany(KiosPayment::class);
    }

    public function akunBank()
    {
        return $this->belongsTo(AkuntanAkunBank::class, 'akun_bank_id');
    }
}
