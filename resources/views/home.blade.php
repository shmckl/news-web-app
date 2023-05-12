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
                    <a href="{{ route('post.show', $post) }}">{{ $post->post_title }}</a>
                </h2>
                <h5 class="card-subtitle mb-2 text-muted">By 
                    <a href="{{ route('profile.show', $post->user->id) }}">{{ $post->user->name }}</a>
                </h5>
            </div>
            <div class="card-body">
                <p class="card-text">{{ $post->post_content }}</p>
            </div>
        </div>
    @endforeach

    <!-- Add this line at the end of your posts list -->
    {{ $posts->links('pagination::simple-bootstrap-5') }}
</div>
@endsection
