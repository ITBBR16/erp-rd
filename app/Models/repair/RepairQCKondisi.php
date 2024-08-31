<?php

namespace App\Models\repair;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RepairQCKondisi extends Model
{
    use HasFactory;

    protected $connection = 'rumahdrone_repair';
    protected $table = 'repair_konidisi';
    protected $guarded = ['id'];

    public function qcFisik()
    {
        return $this->hasMany(RepairQCFisik::class, 'kategori_cek_id');
    }

}
