<?php

namespace App\Models\kios;

use App\Models\kios\KiosOrder;
use Illuminate\Database\Eloquent\Model;
use App\Models\kios\KiosMetodePembayaran;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KiosPayment extends Model
{
    use HasFactory;

    protected $connection = 'rumahdrone_kios';
    protected $table = 'kios_payment';
    protected $guarded = ['id'];

    public function order()
    {
        return $this->belongsTo(KiosOrder::class);
    }
    
    public function metodepembayaran()
    {
        return $this->belongsTo(KiosMetodePembayaran::class, 'metode_pembayaran_id');
    }
    
}
