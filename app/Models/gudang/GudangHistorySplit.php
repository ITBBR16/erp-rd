<?php

namespace App\Models\gudang;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GudangHistorySplit extends Model
{
    use HasFactory;

    protected $connection = 'rumahdrone_gudang';
    protected $table = 'gudang_history_split';
    protected $guarded = ['id'];

    public function historyPart()
    {
        return $this->belongsTo(GudangHistoryPart::class, 'gudang_history_part_id');
    }

    public function produkIdItem()
    {
        return $this->belongsTo(GudangProdukIdItem::class, 'gudang_produk_id_item_id');
    }
}
