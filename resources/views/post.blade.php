@extends('layouts.app')

@section('title', $post->post_title)

@section('content')
    <div class="container">
        <h1 class="text-center my-4">{{ $post->post_title }}</h1>

        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-subtitle mb-2 text-muted">By 
                <a href="{{ route('profile.show', $post->user->id) }}">{{ $post->user->name }}</a>
                </h5>
                <p class="card-text">{{ $post->post_content }}</p>
                <p>Posted on {{ $post->created_at->format('F j, Y') }}</p>
            </div>
        </div>

        @auth
            @if (Auth::user()->id == $post->user_id || Auth::user()->isAdmin())
                <button class="btn btn-primary editPostButton" data-post-id="{{ $post->id }}">Edit Post</button>
                <form class="editPostForm" action="{{ route('post.update', $post) }}" method="POST" data-post-id="{{ $post->id }}" style="display: none;">
                    @csrf
                    @method('PUT')
                    <div class="form-group mt-2">
                        <input type="text" name="post_title" class="form-control" value="{{ $post->post_title }}">
                        <textarea name="post_content" class="form-control" rows="3">{{ $post->post_content }}</textarea>
                    </div>
                    <button type="submit" class="btn btn-success">Submit</button>
                </form>
                <form action="{{ route('post.destroy', $post) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete Post</button>
                </form>
            @endif
        @endauth

        <h3 class="my-4">Comments</h3>

        @foreach ($post->comments as $comment)
            <div class="card mb-2">
                <div class="card-body">
                    <h5 class="card-title">
                        <a href="{{ route('profile.show', $comment->user->id) }}">{{ $comment->user->name }}</a>
                    </h5>
                    <p class="card-text" id="commentText-{{ $comment->id }}">{{ $comment->comment_content }}</p>
                    @auth
                        @if (Auth::user()->id == $comment->user_id || Auth::user()->isAdmin())
                            <button class="btn btn-primary editCommentButton" data-comment-id="{{ $comment->id }}">Edit Comment</button>
                            <form class="editCommentForm" action="{{ route('comment.update', $comment) }}" method="POST" data-comment-id="{{ $comment->id }}" style="display: none;">
                                @csrf
                                @method('PUT')
                                <div class="form-group mt-2">
                                    <textarea name="comment_content" class="form-control" rows="3">{{ $comment->comment_content }}</textarea>
                                </div>
                                <button type="submit" class="btn btn-success">Submit</button>
                            </form>
                            <form action="{{ route('comment.destroy', $comment) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete Comment</button>
                            </form>
                        @endif
                    @endauth
                </div>
            </div>
        @endforeach

        @auth
            <div class="my-4">
                <button id="commentButton" class="btn btn-primary">Add a comment</button>
                <form id="commentForm" action="{{ route('comment.store', $post) }}" method="POST" style="display: none;">
                    @csrf
                    <div class="form-group mt-2">
                        <textarea name="comment_content" class="form-control" rows="3"></textarea>
                    </div>
                    <button type="submit" class="btn btn-success">Submit</button>
                </form>
            </div>
        @endauth
    </div>

    <script>
        document.getElementById('commentButton').addEventListener('click', function() {
            this.style.display = 'none';
            document.getElementById('commentForm').style.display = 'block';
        });

        document.querySelectorAll('.editCommentButton').forEach(function (button) {
            button.addEventListener('click', function () {
                const commentId = this.dataset.commentId;
                const commentForm = document.querySelector(`.editCommentForm[data-comment-id="${commentId}"]`);

                commentForm.style.display = 'block';
                this.style.display = 'none';
            });
        });

        document.querySelectorAll('.editPostButton').forEach(function (button) {
        button.addEventListener('click', function () {
            const postId = this.dataset.postId;
            const postForm = document.querySelector(`.editPostForm[data-post-id="${postId}"]`);

            postForm.style.display = 'block';
            this.style.display = 'none';
        });
    });
    </script>
@endsection
