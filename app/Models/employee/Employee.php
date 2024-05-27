<?php

namespace App\Models\employee;

use App\Models\kios\KiosDailyRecap;
use App\Models\kios\KiosTransaksi;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $connection = 'rumahdrone_employee';
    protected $table = 'employee';
    protected $guarded = ['id'];

    public function dailyrecap()
    {
        return $this->hasMany(KiosDailyRecap::class);
    }

    public function transaksikios()
    {
        return $this->hasMany(KiosTransaksi::class);
    }

}
