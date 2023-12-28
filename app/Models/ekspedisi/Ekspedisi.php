<?php

namespace App\Models\ekspedisi;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ekspedisi extends Model
{
    use HasFactory;

    protected $connection = 'rumahdrone_ekspedisi';
    protected $table = 'ekspedisi';
    protected $guarded = ['id'];

    public function pelayanan()
    {
        return $this->hasMany(JenisPelayanan::class);
    }
}
