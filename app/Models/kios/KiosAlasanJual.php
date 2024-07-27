<?php

namespace App\Models\kios;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KiosAlasanJual extends Model
{
    use HasFactory;

    protected $connection = 'rumahdrone_kios';
    protected $table = 'kios_alasan_jual';
    protected $guarded = ['id'];

    public function orderSecondKios()
    {
        return $this->hasMany(KiosOrderSecond::class);
    }
}
