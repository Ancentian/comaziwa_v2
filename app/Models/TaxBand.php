<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaxBand extends Model
{
    use HasFactory;

    protected $fillable = [
        'tenant_id',
        'min',
        'max',
        'rate'
    ];
}
