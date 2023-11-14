<?php

namespace App\Models\divisi;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Divisi extends Model
{
    use HasFactory;

    protected $connection = 'rumahdrone_employee';
    protected $table = 'divisi';

    protected $guarded = ['id'];
}
