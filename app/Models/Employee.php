<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Employee extends Authenticatable
{
    use HasFactory;
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'phone_no',
        'staff_no',
        'position',
        'dob',
        'ssn',
        'bank_name',
        'account_no',
        'branch_name',
        'branch_shortcode',
        'tenant_id',
        'contrac_type',
        'password',
        'nok_name',
        'nok_phone',
        'address'
    ];

    protected $hidden = [
        'password'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'password' => 'hashed',
    ];
}
