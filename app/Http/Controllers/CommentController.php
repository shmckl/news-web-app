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


    // Change the method signature to include the Comment instance
public function destroy(Request $request, Comment $comment)
{
    if($request->user()->cannot('update', $comment) && !$request->user()->isAdmin()) {
        abort(403);
    }

    // Add a check to make sure the user is authorized to delete the comment
    if ($request->user()->id !== $comment->user_id) {
        return redirect()->route('post.show', $comment->post)->with('error', 'You are not authorized to delete this comment.');
    }

    $comment->delete();

    return redirect()->route('post.show', $comment->post)->with('success', 'Comment deleted successfully!');
}

// Change the method signature to include the Comment instance
public function update(Request $request, Comment $comment)
{
    if($request->user()->cannot('update', $comment) && !$request->user()->isAdmin()) {
        abort(403);
    }

    $request->validate([
        'comment_content' => 'required',
    ]);

    // Add a check to make sure the user is authorized to update the comment
    if ($request->user()->id !== $comment->user_id) {
        return redirect()->route('post.show', $comment->post)->with('error', 'You are not authorized to update this comment.');
    }

    $comment->comment_content = $request->comment_content;
    $comment->save();

    return redirect()->route('post.show', $comment->post)->with('success', 'Comment updated successfully!');
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
        return view('home', [
            'comments' => Comment::latest()->get(),
        ]);
    }
}
