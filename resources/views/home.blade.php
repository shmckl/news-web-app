@extends('layouts.app')

@section('title', 'Latest Posts')

@section('content')
<div class="container">
    <h1 class="text-center my-4">Latest Posts</h1>

    @auth
        <div class="text-center mb-4">
            <a href="{{ route('newpost') }}" class="btn btn-primary">Create Post</a>
        </div>
    @endauth

    @foreach ($posts as $post)
        <div class="card mb-4">
            <div class="card-header">
                <h2 class="card-title">
                    <a href="{{ route('post.show', $post->slug) }}">{{ $post->post_title }}</a>
                </h2>
                <h5 class="card-subtitle mb-2 text-muted">By 
                    <a href="{{ route('profile.show', $post->user->name) }}">{{ $post->user->name }}</a>
                </h5>
            </div>
            @if($post->post_image)
                <div class="card-img-top">
                    <img src="{{ asset('images/'.$post->post_image) }}" alt="{{ $post->post_title }}" style="max-width:100%;max-height:400px;">
                </div>
            @endif
            <div class="card-body">
                <p class="card-text">{{ $post->post_content }}</p>
                <h5 class="mb-2 text-muted">Posted {{ $post->created_at->diffForHumans() }}</h5>

                <!-- Comments Section -->
                <hr>
                <h4>Comments:</h4>
                @foreach ($post->comments as $comment)
                    <div class="card mt-4">
                        <div class="card-body">
                            <h5 class="card-title">{{ $comment->user->name }}</h5>
                            <h6 class="card-subtitle mb-2 text-muted">Commented {{ $comment->created_at->diffForHumans() }}</h6>
                            <p class="card-text">{{ $comment->comment_content }}</p>
                        </div>
                    </div>
                @endforeach

                <!-- Add new comment -->
                @auth
                    <hr>
                    <h4>Add a comment:</h4>
                    <form action="{{ route('comment.store', $post) }}" method="post">
                        @csrf
                        <div class="form-group">
                            <textarea class="form-control" name="comment_content" required></textarea>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                @endauth
            </div>
        </div>
    @endforeach

    {{ $posts->links('pagination::simple-bootstrap-5') }}
</div>
@endsection
