<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    // 1. Lấy danh sách bài viết cho Trang chủ
    public function index()
    {
        $posts = DB::table('posts')
            ->join('users', 'posts.user_id', '=', 'users.id')
            ->select('posts.*', 'users.name as author_name')
            ->orderBy('posts.created_at', 'desc')
            ->get();

        return view('home', compact('posts'));
    }

    // 2. Hàm xem chi tiết bài viết theo ID
    public function showById($id)
    {
        $post = DB::table('posts')
            ->join('users', 'posts.user_id', '=', 'users.id')
            ->select('posts.*', 'users.name as author_name')
            ->where('posts.id', $id)
            ->first();

        if (!$post) {
            abort(404, 'Không tìm thấy bài viết này!');
        }

        return view('posts.detail', compact('post'));
    }
} // <-- Đảm bảo có đủ dấu đóng class ở cuối cùng này nhé!