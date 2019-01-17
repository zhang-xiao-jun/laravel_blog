<!doctype html>
<html lang="en">
<head>
    <title>{{ config('blog.title') }}</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
<body>
<div class="container">
    <h1>{{ $post->title }}</h1>
    <h5>{{ $post->puslished_at }}</h5>
    <hr>
    {!! nl2br(e($post->content))  !!}
    <hr>
    <button class="btn btn-primary" onclick="history.go(-1)">
        << Back
    </button>
</div>
</body>
</html>