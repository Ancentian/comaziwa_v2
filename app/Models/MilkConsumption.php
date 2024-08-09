<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MilkConsumption extends Model
{
    use HasFactory;

    protected $table = 'milk_consumptions';

    protected $guarded = [];
}
