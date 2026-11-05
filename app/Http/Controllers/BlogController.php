<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BlogController extends Controller
{
    public function index()
    {
        $posts = BlogPost::all();
        return view('blog', compact('posts'));
    }

    public function show($slug)
    {
        $post = BlogPost::where('slug', $slug)->first();

        if ($post) {
            return view('blog.show', compact('post'));
        }

        // Old links: a slug the post used to have, or the earlier "title-4" format.
        $id = DB::table('blog_post_old_slugs')->where('slug', $slug)->value('blog_post_id')
            ?? (preg_match('/(\d+)$/', $slug, $matches) ? $matches[1] : null);

        $post = BlogPost::findOrFail($id);

        return redirect()->route('blog.show', $post->slug, 301);
    }
}
