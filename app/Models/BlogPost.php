<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlogPost extends Model
{
    protected $casts = [
        'content' => 'array',
        'meta_data' => 'array',
    ];
}
