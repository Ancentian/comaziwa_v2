<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoreSale extends Model
{
    use HasFactory;

    protected $table = 'store_sales';
    protected $guarded = ['id'];
}
