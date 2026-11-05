<?php

namespace App\Http\Controllers;

use App\Models\PressRelease;
use Illuminate\Http\Request;

class PressReleaseController extends Controller
{
    public function index()
    {
        $posts = PressRelease::all();
        return view('press_release.index', compact('posts'));
    }

    public function show($id)
    {
        $id = preg_match('/(\d+)$/', $id, $matches) ? $matches[1] : $id;
        $post = PressRelease::findOrFail($id);
        return view('press_release.show', compact('post'));
    }
}
