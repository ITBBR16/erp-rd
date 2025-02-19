<?php

namespace App\Models\kios;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KiosProdukBnob extends Model
{
    use HasFactory;

    protected $connection = 'rumahdrone_kios';
    protected $table = 'kios_produk_bnob';
    protected $guarded = ['id'];

    public function kelengkapanSplit()
    {
        return $this->hasMany(KiosListKelengkapanSplit::class);
    }
}
