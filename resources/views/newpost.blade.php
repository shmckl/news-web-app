@extends('layouts.app')

@section('title', 'Create a Post')

@section('content')
<div class="container">
    <h1 class="text-center my-4">Create a Post</h1>

    <form id="createPostForm" action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="post_title">Title</label>
            <input type="text" name="post_title" id="post_title" class="form-control" placeholder="Post Title">
            <span id="post_title_error" class="text-danger"></span>
        </div>
        <div class="form-group">
            <label for="post_content">Content</label>
            <textarea name="post_content" id="post_content" class="form-control" placeholder="Post Content"></textarea>
            <span id="post_content_error" class="text-danger"></span>
        </div>
        <div class="form-group" id="imageUpload" style="display: none;">
            <label for="post_image">Image</label>
            <input type="file" name="post_image" id="post_image" class="form-control">
        </div>
        <div class="form-group">
            <button type="button" id="addImageButton" class="btn btn-secondary">Add Image</button>
            <button type="submit" class="btn btn-primary">Create Post</button>
        </div>
    </form>
</div>

<script>
    document.getElementById('addImageButton').addEventListener('click', function() {
        document.getElementById('imageUpload').style.display = 'block';
        this.style.display = 'none';
    });

    document.getElementById('createPostForm').addEventListener('submit', function(event) {
        const postTitle = this.querySelector('#post_title');
        const postContent = this.querySelector('#post_content');
        let validationError = false;

        if (!postTitle.value.trim()) {
            event.preventDefault();
            postTitle.classList.add('is-invalid');
            document.querySelector('#post_title_error').textContent = 'Post title is required.';
            validationError = true;
        } else {
            postTitle.classList.remove('is-invalid');
            document.querySelector('#post_title_error').textContent = '';
        }

        if (!postContent.value.trim()) {
            event.preventDefault();
            postContent.classList.add('is-invalid');
            document.querySelector('#post_content_error').textContent = 'Post content is required.';
            validationError = true;
        } else {
            postContent.classList.remove('is-invalid');
            document.querySelector('#post_content_error').textContent = '';
        }

        if (validationError) {
            event.preventDefault();
        }
    });
</script>

@endsection
