<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    public function show (Post $post)
    {
        return view('posts.show', [
            'post' => $post,
        ]);
    }

    public function store (Request $request)
    {
        $request->validate([
            'post_title' => 'required',
            'post_content' => 'required',
        ]);

        $post = new Post();
        $post->post_title = $request->post_title;
        $post->post_content = $request->post_content;
        $post->user_id = $request->user()->id;
        $post->save();

        return redirect()->route('welcome')->with('success', 'Post created successfully!');
    }

    public function index()
    {
        return view('welcome', [
            'posts' => Post::latest()->get(),
        ]);
    }
}
