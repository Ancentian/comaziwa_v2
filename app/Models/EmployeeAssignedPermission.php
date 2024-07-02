<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeAssignedPermission extends Model
{
    use HasFactory;

    protected $table = 'employee_assigned_permissions';

    protected $fillable = [
        'employee_id',
        'permission_id',
    ];
}
