<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class BlogPost extends Model
{
    protected $casts = [
        'content' => 'array',
        'meta_data' => 'array',
    ];

    protected static function booted(): void
    {
        static::updated(function (BlogPost $post) {
            if (! $post->wasChanged('slug')) {
                return;
            }

            // The new slug is now the post's live URL, so it can't also be a redirect.
            DB::table('blog_post_old_slugs')->where('slug', $post->slug)->delete();

            if ($post->getOriginal('slug')) {
                DB::table('blog_post_old_slugs')->updateOrInsert(
                    ['slug' => $post->getOriginal('slug')],
                    ['blog_post_id' => $post->id, 'updated_at' => now(), 'created_at' => now()],
                );
            }
        });
    }
}
