@extends('layouts.app')

@section('title', 'Profile')

@section('content')
    <div class="container">
        <h1 class="text-center my-4">{{ $user->name }}'s Profile</h1>

        <h2>Posts</h2>
        @foreach ($posts as $post)
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title">
                        <a href="{{ route('post.show', $post->slug) }}">{{ $post->post_title }}</a>
                    </h5>
                    @if($post->post_image)
                        <img src="{{ asset('images/'.$post->post_image) }}" alt="{{ $post->post_title }}" style="max-width:50%;max-height:500px;">
                    @endif
                    <p class="card-text">{{ $post->post_content }}</p>
                    <p>Posted on {{ $post->created_at->format('F j, Y') }}</p>
                </div>
            </div>
        @endforeach

        <h2 class="my-4">Comments</h2>
        @foreach ($user->comments as $comment)
            <div class="card mb-2">
                <div class="card-body">
                    <h5 class="card-title">
                        Comment on <a href="{{ route('post.show', $comment->post->slug) }}">{{ $comment->post->post_title }}</a>
                    </h5>
                    <p class="card-text">{{ $comment->comment_content }}</p>
                    <p>Commented on {{ $comment->created_at->format('F j, Y') }}</p>
                </div>
            </div>
        @endforeach
    </div>
@endsection
