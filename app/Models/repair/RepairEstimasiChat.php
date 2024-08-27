<?php

namespace App\Models\repair;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RepairEstimasiChat extends Model
{
    use HasFactory;

    protected $connection = 'rumahdrone_repair';
    protected $table = 'repair_chat_estimasi';
    protected $guarded = ['id'];

    public function estimasi()
    {
        return $this->belongsTo(RepairEstimasi::class, 'estimasi_id');
    }

}
