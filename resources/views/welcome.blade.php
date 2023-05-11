<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CSC348B Web App</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1 class="text-center my-4">Latest Posts</h1>

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

    <!-- ootstrap JavaScript -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
