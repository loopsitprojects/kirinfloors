<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'price',
        'qty',
        'image',
        'additional_images',
        'category',
        'design_code',
        'design_grain',
        'colour_tone',
        'texture',
        'application',
        'dimensions',
        'short_description',
        'description',
        'meta_details',
    ];

    protected $casts = [
        'additional_images' => 'array',
    ];
}
