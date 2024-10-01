<?php

namespace App\Models\management;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AkuntanDocumentMonth extends Model
{
    use HasFactory;

    protected $connection = 'rumahdrone_management';
    protected $table = 'akuntan_document_month';
    protected $guarded = ['id'];

    public function mutasiSementara()
    {
        return $this->belongsTo(AkuntanMutasiMonth::class, 'table_id');
    }
}
