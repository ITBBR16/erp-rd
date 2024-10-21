<?php

namespace App\Models\management;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AkuntanTransaksi extends Model
{
    use HasFactory;

    protected $connection = 'rumahdrone_management';
    protected $table = 'akuntan_transaksi';
    protected $guarded = ['id'];

}
