<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MilkSpillage extends Model
{
    use HasFactory;

    protected $table = 'milk_spillages';
    protected $guarded = ['id'];
}
