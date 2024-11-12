<?php

namespace App\Models\gudang;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GudangKomplain extends Model
{
    use HasFactory;

    protected $connection = 'rumahdrone_gudang';
    protected $table = 'gudang_komplain';
    protected $guarded = ['id'];

    public function gudangQC()
    {
        return $this->belongsTo(GudangQualityControll::class, 'gudang_quality_controll');
    }

}
