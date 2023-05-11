@extends('layouts.app')

@section('title', 'Create a Post')

@section('content')
<div class="container">
        <h1 class="text-center my-4">Create a Post</h1>

        <form action="{{ route('posts.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="post_title">Title</label>
                <input type="text" name="post_title" id="post_title" class="form-control" placeholder="Post Title">
            </div>
            <div class="form-group">
                <label for="post_content">Content</label>
                <textarea name="post_content" id="post_content" class="form-control" placeholder="Post Content"></textarea>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Create Post</button>
            </div>
        </form>
    </div>
@endsection