<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        // Old slugs keep redirecting after a post's slug is changed.
        Schema::create('blog_post_old_slugs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('blog_post_id')->constrained()->cascadeOnDelete();
            $table->string('slug')->unique();
            $table->timestamps();
        });

        // URLs now come from the slug alone, so every post needs a unique one.
        DB::table('blog_posts')->whereNull('slug')->orderBy('id')->each(function ($post) {
            $base = Str::slug($post->title);
            $slug = $base;

            for ($i = 2; DB::table('blog_posts')->where('slug', $slug)->exists(); $i++) {
                $slug = "{$base}-{$i}";
            }

            DB::table('blog_posts')->where('id', $post->id)->update(['slug' => $slug]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('blog_post_old_slugs');
    }
};
