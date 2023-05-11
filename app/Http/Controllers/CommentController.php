<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Post;

class CommentController extends Controller
{
    public function store(Request $request, Post $post)
{
    $request->validate([
        'comment_content' => 'required',
    ]);

    $comment = new Comment();
    $comment->comment_content = $request->comment_content;
    $comment->user_id = $request->user()->id;
    $comment->post_id = $post->id;
    $comment->save();

    return redirect()->route('post.show', $post)->with('success', 'Comment created successfully!');
}


    public function destroy(Request $request)
    {
        $comment = Comment::find($request->comment_id);
        $comment->delete();

        return redirect()->route('post.show')->with('success', 'Comment deleted successfully!');
    }

    public function update(Request $request)
    {
        $request->validate([
            'comment_content' => 'required',
        ]);

        $comment = Comment::find($request->comment_id);
        $comment->comment_content = $request->comment_content;
        $comment->save();

        return redirect()->route('post.show')->with('success', 'Comment updated successfully!');
    }

    public function edit(Request $request)
    {
        $comment = Comment::find($request->comment_id);

        return view('editcomment', [
            'comment' => $comment,
        ]);
    }

    public function show(Comment $comment)
    {
        return view('comment', [
            'comment' => $comment,
        ]);
    }

    public function index()
    {
        return view('welcome', [
            'comments' => Comment::latest()->get(),
        ]);
    }
}
