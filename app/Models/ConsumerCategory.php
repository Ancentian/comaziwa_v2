<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConsumerCategory extends Model
{
    use HasFactory;

    protected $table = 'consumer_categories';
    protected $fillable = [
        'tenant_id',
        'name',
        'status',
        'description',
    ];
}
