<?php

namespace App\Models\employee;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusEmployee extends Model
{
    use HasFactory;

    protected $connection = 'rumahdrone_employee';
    protected $table = 'status';
    protected $guarded = ['id'];

    public function employee()
    {
        return $this->hasMany(Employee::class);
    }
}
