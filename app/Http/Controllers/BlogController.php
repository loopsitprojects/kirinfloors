<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index()
    {
        $posts = BlogPost::all();
        return view('blog', compact('posts'));
    }

    public function show($id)
    {
        $id = preg_match('/(\d+)$/', $id, $matches) ? $matches[1] : $id;
        $post = BlogPost::findOrFail($id);
        return view('blog.show', compact('post'));
    }
}
