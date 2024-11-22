<?php

namespace App\Models\gudang;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GudangHistoryPart extends Model
{
    use HasFactory;

    protected $connection = 'rumahdrone_gudang';
    protected $table = 'gudang_history_part';
    protected $guarded = ['id'];

    public function historySplit()
    {
        return $this->hasMany(GudangHistorySplit::class);
    }

    public function produkIdItem()
    {
        return $this->belongsTo(GudangProdukIdItem::class, 'gudang_produk_id_item_id');
    }
}
