<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Leave extends Model
{
    use HasFactory;

    protected $fillable = [
        'tenant_id',
        'employee_id',
        'type',
        'date_from',
        'date_to',
        'remaining_days',
        'reasons',
        'status',
        'supervisor_id'
    ];
}
