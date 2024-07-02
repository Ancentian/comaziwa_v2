<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'tenant_id',
        'title',
        'start_date',
        'due_date',
        'priority',
        'team_leader',
        'project_team',
        'progress',
        'notes'
    ];
}
