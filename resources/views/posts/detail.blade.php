<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Chi tiết bài viết</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
</head>
<body class="p-5">
    <div class="container" style="max-width: 600px;">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h4>Chi tiết bài viết (ID: {{ $post->id }})</h4>
            </div>
            <div class="card-body">
                <p><strong>Slug:</strong> {{ $post->slug }}</p>
                <p><strong>Title:</strong> {{ $post->title }}</p>
                <p><strong>Content:</strong></p>
                <div class="p-3 bg-light border rounded">
                    {{ $post->content }}
                </div>
            </div>
        </div>
    </div>
</body>
</html>