<?php

namespace App\Models\customer;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogAdmin extends Model
{
    use HasFactory;

    protected $connection = 'rumahdrone_customer';

    protected $table = 'log';
}
