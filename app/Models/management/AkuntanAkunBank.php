<?php

namespace App\Models\management;

use App\Models\gudang\GudangMetodePembayaran;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AkuntanAkunBank extends Model
{
    use HasFactory;

    protected $connection = 'rumahdrone_management';
    protected $table = 'akuntan_akun_bank';
    protected $guarded = ['id'];

    public function gudangMP()
    {
        return $this->hasMany(GudangMetodePembayaran::class);
    }
}
