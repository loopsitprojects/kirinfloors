<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PressRelease extends Model
{
    protected $fillable = [
        'category',
        'title',
        'short_description',
        'image_path',
        'content',
        'meta_data',
    ];

    protected $casts = [
        'content' => 'array',
        'meta_data' => 'array',
    ];
}
