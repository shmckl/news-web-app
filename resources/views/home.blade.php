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
                    <h2 class="card-title">{{ $post->post_title }}</h2>
                    <h5 class="card-subtitle mb-2 text-muted">By {{ $post->user->name }}</h5>
                </div>
                <div class="card-body">
                    <p class="card-text">{{ $post->post_content }}</p>
                    <p class="font-weight-bold">Comments:</p>
                    <ul>
                        @foreach ($post->comments as $comment)
                            <li>
                                <strong>{{ $comment->user->name }}</strong>: {{ $comment->comment_content }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endforeach
    </div>
@endsection