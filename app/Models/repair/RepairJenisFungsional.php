<?php

namespace App\Models\repair;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RepairJenisFungsional extends Model
{
    use HasFactory;

    protected $connection = 'rumahdrone_repair';
    protected $table = 'repair_jenis_fungsional';
    protected $guarded = ['id'];

    public function case()
    {
        return $this->hasMany(RepairCase::class);
    }
}
