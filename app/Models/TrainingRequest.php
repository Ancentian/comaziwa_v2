<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainingRequest extends Model
{
    use HasFactory;
    protected $fillable = [
        'employee_id',
        'training_id',
        'completion_status',
        'approval_status',
        'certificate',
        'is_invited',
        'decline_reasons',
    ];
}
