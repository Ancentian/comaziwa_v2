<?php

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\EmployeeAssignedPermission;

function company()
{
    return new App\Helpers\CompanyHelper();
}

function settings()
{
    return new App\Helpers\EmailSettingsHelper();
}

function num_format($number)
{
    return number_format($number,2,'.',',');
}

function format_date($date){
    return date('d/m/Y',strtotime($date));
}

function format_datetime($date){
    return date('d/m/Y H:i',strtotime($date));
}

function staffcan($expression){
    
    if(empty(session('is_admin')) || session('is_admin') == 0){
        return true;
    }
    
    $id = optional(auth()->guard('employee')->user())->id;
    $perms = EmployeeAssignedPermission::join('employee_permissions','employee_permissions.id','employee_assigned_permissions.permission_id')
                                    ->where('employee_id',$id)
                                    ->where('employee_permissions.name',$expression)->count();
    
    if($perms > 0){
        return true;
    }else{
        return false;
    }
    
}

function usercan($expression){
    if(Auth::user()->is_system == 1){
        return true;
    }

    $role = Role::find(auth()->user()->role_id);

    if(empty($role)){
        return false;
    }

    $permissions = $role->permissions->pluck('name')->toArray(); 

    if(in_array($expression,$permissions)){
        return true;
    }else{
        return false;
    }
}