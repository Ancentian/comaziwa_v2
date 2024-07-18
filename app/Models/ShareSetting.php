<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShareSetting extends Model
{
    use HasFactory;

    protected $table = 'share_settings';
    protected $guarded = ['id'];
}
