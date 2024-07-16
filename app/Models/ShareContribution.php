<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShareContribution extends Model
{
    use HasFactory;

    protected $table = 'share_contributions';
    
    protected $guarded = ['id'];
}
