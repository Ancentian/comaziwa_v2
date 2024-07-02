<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'tenant_id',
        'name',
        'ssni_est',
        'address',
        'email',
        'tel_no',
        'logo',
        'tin',
        'land_line',
        'secondary_email'
    ];
}
