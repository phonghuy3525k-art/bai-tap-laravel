<?php

use App\Http\Controllers\PostController;

// Trang chủ hiển thị danh sách bài viết
Route::get('/', [PostController::class, 'index']);

// Trang chi tiết bài viết
Route::get('/posts/{id}', [PostController::class, 'showById']);