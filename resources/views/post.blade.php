<!DOCTYPE html>
<html lang="">
<head>
    <title>Post Information</title>
</head>
<body>
<h1>Posts</h1>
@foreach ($postData as $post)
    <div>
        <h2>Post ID: {{ $post['id'] }}</h2>
        <p>Title: {{ $post['title'] }}</p>
        <p>Body: {{ $post['body'] }}</p>
    </div>
    <hr>
@endforeach
</body>
</html>
