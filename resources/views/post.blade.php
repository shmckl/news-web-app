@extends('layouts.app')

@section('title', $post->post_title)

@section('content')
    <div class="container">
        <h1 class="text-center my-4">{{ $post->post_title }}</h1>

        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-subtitle mb-2 text-muted">By {{ $post->user->name }}</h5>
                <p class="card-text">{{ $post->post_content }}</p>
                <p>Posted on {{ $post->created_at->format('F j, Y') }}</p>
            </div>
        </div>

        <h3 class="my-4">Comments</h3>

        @foreach ($post->comments as $comment)
            <div class="card mb-2">
                <div class="card-body">
                    <h5 class="card-title">{{ $comment->user->name }}</h5>
                    <p class="card-text">{{ $comment->comment_content }}</p>
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
    </script>
@endsection
