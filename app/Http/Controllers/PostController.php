<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    public function show (Post $post)
    {
        return view('post', [
            'post' => $post,
        ]);
    }

    public function store (Request $request)
    {
        $request->validate([
            'post_title' => 'required',
            'post_content' => 'required',
            'post_image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $post = new Post();
        $post->post_title = $request->post_title;
        $post->post_content = $request->post_content;
        $post->user_id = $request->user()->id;

        if($request->hasFile('post_image')){
            $imageName = time().'.'.$request->post_image->extension();  
            $request->post_image->move(public_path('images'), $imageName);
            $post->post_image = $imageName;
        }

        $post->save();

        return redirect()->route('home')->with('success', 'Post created successfully!');
    }


    public function index()
    {
        return view('home', [
            'posts' => Post::latest()->paginate(10),
        ]);
    }

    public function update(Request $request, Post $post)
{
    if ($request->user()->cannot('update', $post) && !$request->user()->isAdmin()) {
        abort(403);
    }

    // Allow admin user to bypass the authorization check
    if (!$request->user()->isAdmin() && $request->user()->id !== $post->user_id) {
        return redirect()->route('post.show', $post)->with('error', 'You are not authorized to update this post.');
    }

    $request->validate([
        'post_title' => 'required',
        'post_content' => 'required',
        'post_image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ]);

    $post->post_title = $request->post_title;
    $post->post_content = $request->post_content;
    if($request->hasFile('post_image')){
        $imageName = time().'.'.$request->post_image->extension();  
        $request->post_image->move(public_path('images'), $imageName);
        $post->post_image = $imageName;
    }
    $post->save();

    return redirect()->route('post.show', $post)->with('success', 'Post updated successfully!');
}

public function destroy(Request $request, Post $post)
{
    if ($request->user()->cannot('update', $post) && !$request->user()->isAdmin()) {
        abort(403);
    }

    // Allow admin user to bypass the authorization check
    if (!$request->user()->isAdmin() && $request->user()->id !== $post->user_id) {
        return redirect()->route('post.show', $post)->with('error', 'You are not authorized to delete this post.');
    }

    $post->delete();

    return redirect()->route('home')->with('success', 'Post deleted successfully!');
}

}
