@extends('layouts.app')

@section('title', $post->post_title)

@section('content')
    <div class="container">
        <h1 class="text-center my-4">{{ $post->post_title }}</h1>

        @if($post->post_image)
        <img src="{{ asset('images/' . $post->post_image) }}" alt="{{ $post->post_title }}" class="img-fluid">
        @endif

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
                        <input type="text" name="post_title" class="form-control" id="post_title" value="{{ old('post_title', $post->post_title) }}">
                        <span id="post_title_error" class="text-danger"></span>
                        <textarea name="post_content" class="form-control" id="post_content" rows="3">{{ old('post_content', $post->post_content) }}</textarea>
                        <span id="post_content_error" class="text-danger"></span>
                    </div>
                    <button type="submit" class="btn btn-success">Submit</button>
                    <button type="button" class="btn btn-secondary cancelEditPostButton" data-post-id="{{ $post->id }}">Cancel</button>

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
                                <textarea name="comment_content" class="form-control" rows="3" data-comment-id="{{ $comment->id }}">{{ $comment->comment_content }}</textarea>
                                </div>
                                <button type="submit" class="btn btn-success">Submit</button>
                                <button type="button" class="btn btn-secondary cancelEditCommentButton" data-comment-id="{{ $comment->id }}">Cancel</button>
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
                    <button type="button" class="btn btn-secondary" id="cancelNewCommentButton">Cancel</button>
                </form>
            </div>
        @endauth
    </div>

    <script>
        document.getElementById('commentForm').addEventListener('submit', function(event) {
            const textarea = this.querySelector('textarea');

            if (!textarea.value.trim()) {
                event.preventDefault();
                textarea.classList.add('is-invalid');
                if (!document.querySelector('#emptyCommentError')) {
                    const error = document.createElement('div');
                    error.id = 'emptyCommentError';
                    error.classList.add('invalid-feedback');
                    error.textContent = 'Comment content is required.';
                    textarea.parentNode.appendChild(error);
                }
            } else {
                textarea.classList.remove('is-invalid');
                const error = document.querySelector('#emptyCommentError');
                if (error) {
                    error.remove();
                }
            }
        });

        document.getElementById('commentButton').addEventListener('click', function() {
            const form = document.getElementById('commentForm');
            form.style.display = 'block';
            this.style.display = 'none';

            // Clear the textarea and remove any validation error messages
            const textarea = form.querySelector('textarea');
            textarea.value = '';
            textarea.classList.remove('is-invalid');
            const error = document.querySelector('#emptyCommentError');
            if (error) {
                error.remove();
            }
        });

        document.querySelectorAll('.editCommentButton').forEach(function (button) {
            button.addEventListener('click', function () {
                const commentId = this.dataset.commentId;
                const commentForm = document.querySelector(`.editCommentForm[data-comment-id="${commentId}"]`);
                const commentText = document.getElementById(`commentText-${commentId}`);

                // Set the existing comment content as the textarea value
                const textarea = commentForm.querySelector('textarea');
                textarea.value = commentText.textContent.trim();

                commentForm.style.display = 'block';
                this.style.display = 'none';
            });
        });

        document.querySelectorAll('.cancelEditCommentButton').forEach(function (button) {
            button.addEventListener('click', function () {
                const commentId = this.dataset.commentId;
                const commentForm = document.querySelector(`.editCommentForm[data-comment-id="${commentId}"]`);
                const editButton = document.querySelector(`.editCommentButton[data-comment-id="${commentId}"]`);

                commentForm.style.display = 'none';
                editButton.style.display = 'block';

                // Clear validation message
                const textarea = commentForm.querySelector('textarea');
                textarea.classList.remove('is-invalid');
            });
        });

        document.querySelectorAll('.editCommentForm').forEach(function (form) {
            form.addEventListener('submit', function (event) {
                const textarea = this.querySelector('textarea');

                if (!textarea.value.trim()) {
                    event.preventDefault();
                    textarea.classList.add('is-invalid');
                    if (!document.querySelector(`#emptyEditCommentError-${textarea.dataset.commentId}`)) {
                        const error = document.createElement('div');
                        error.id = `emptyEditCommentError-${textarea.dataset.commentId}`;
                        error.classList.add('invalid-feedback');
                        error.textContent = 'Comment content is required.';
                        textarea.parentNode.appendChild(error);
                    }
                } else {
                    textarea.classList.remove('is-invalid');
                    const error = document.querySelector(`#emptyEditCommentError-${textarea.dataset.commentId}`);
                    if (error) {
                        error.remove();
                    }
                }
            });
        });


        document.querySelectorAll('.editPostButton').forEach(function (button) {
        button.addEventListener('click', function () {
            const postId = this.dataset.postId;
            const postForm = document.querySelector(`.editPostForm[data-post-id="${postId}"]`);

            postForm.style.display = 'block';
            this.style.display = 'none';
        });

        document.querySelectorAll('.cancelPostButton').forEach(function (button) {
            button.addEventListener('click', function () {
                const postId = this.closest('.editPostForm').dataset.postId;
                const postForm = document.querySelector(`.editPostForm[data-post-id="${postId}"]`);
                const postButton = document.querySelector(`.editPostButton[data-post-id="${postId}"]`);

                postForm.style.display = 'none';
                postButton.style.display = 'block';
            });
        });

        document.querySelectorAll('.cancelCommentButton').forEach(function (button) {
            button.addEventListener('click', function () {
                const commentId = this.closest('.editCommentForm').dataset.commentId;
                const commentForm = document.querySelector(`.editCommentForm[data-comment-id="${commentId}"]`);
                const commentButton = document.querySelector(`.editCommentButton[data-comment-id="${commentId}"]`);

                commentForm.style.display = 'none';
                commentButton.style.display = 'block';
            });
        });

        document.getElementById('cancelNewCommentButton').addEventListener('click', function() {
            document.getElementById('commentForm').style.display = 'none';
            document.getElementById('commentButton').style.display = 'block';
        });

        document.querySelectorAll('.editPostForm').forEach(function (form) {
            form.addEventListener('submit', function (event) {
                const postTitle = this.querySelector('input[name="post_title"]');
                const postContent = this.querySelector('textarea[name="post_content"]');

                if (!postTitle.value.trim()) {
                    event.preventDefault();
                    postTitle.classList.add('is-invalid');
                    if (!document.querySelector('#emptyPostTitleError')) {
                        const error = document.createElement('div');
                        error.id = 'emptyPostTitleError';
                        error.classList.add('invalid-feedback');
                        error.textContent = 'Post title is required.';
                        postTitle.parentNode.appendChild(error);
                    }
                } else {
                    postTitle.classList.remove('is-invalid');
                    const error = document.querySelector('#emptyPostTitleError');
                    if (error) {
                        error.remove();
                    }
                }

                if (!postContent.value.trim()) {
                    event.preventDefault();
                    postContent.classList.add('is-invalid');
                    if (!document.querySelector('#emptyPostContentError')) {
                        const error = document.createElement('div');
                        error.id = 'emptyPostContentError';
                        error.classList.add('invalid-feedback');
                        error.textContent = 'Post content is required.';
                        postContent.parentNode.appendChild(error);
                    }
                } else {
                    postContent.classList.remove('is-invalid');
                    const error = document.querySelector('#emptyPostContentError');
                    if (error) {
                        error.remove();
                    }
                }
            });
        });


        document.querySelectorAll('.cancelEditPostButton').forEach(function (button) {
            button.addEventListener('click', function () {
                const postId = this.dataset.postId;
                const postForm = document.querySelector(`.editPostForm[data-post-id="${postId}"]`);
                const editPostButton = document.querySelector(`.editPostButton[data-post-id="${postId}"]`);

                // Reset the form fields and remove error messages
                document.getElementById('post_title').value = '{{ old('post_title', $post->post_title) }}';
                document.getElementById('post_content').value = '{{ old('post_content', $post->post_content) }}';
                document.getElementById('post_title_error').textContent = '';
                document.getElementById('post_content_error').textContent = '';

                // Hide the form and show the "Edit" button
                postForm.style.display = 'none';
                editPostButton.style.display = 'block';
            });
        });
    });
    </script>
@endsection
