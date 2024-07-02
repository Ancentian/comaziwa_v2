<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CollectionCenter extends Model
{
    use HasFactory;

    protected $table = 'collection_centers';
    protected $guarded = ['id'];
}
