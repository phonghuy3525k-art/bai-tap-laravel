<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    // Hiển thị danh sách bài viết
    public function index()
    {
        // Thay đổi cách viết truy vấn lấy danh sách mới nhất
        $danhSachBaiViet = Post::with('user')->orderBy('id', 'desc')->paginate(5);
        
        // Đổi tên thư mục view thành 'baiviet' thay vì 'posts'
        return view('baiviet.index', compact('danhSachBaiViet'));
    }

    // Form tạo bài viết
    public function create()
    {
        return view('baiviet.create');
    }

    // Lưu bài viết mới
    public function store(Request $request)
    {
        $duLieuHopLe = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,gif', 'max:3072'],
        ], [
            'title.required' => 'Tiêu đề không được để trống nha.',
            'content.required' => 'Nội dung bài viết không được bỏ trống.',
            'image.image' => 'File tải lên bắt buộc phải là hình ảnh.',
        ]);

        $duongDanAnh = null;
        if ($request->hasFile('image')) {
            // Đổi tên thư mục lưu trữ ảnh trong storage
            $duongDanAnh = $request->file('image')->store('images_baiviet', 'public');
        }

        Post::create([
            'user_id' => auth()->user()->id,
            'title' => $duLieuHopLe['title'],
            'content' => $duLieuHopLe['content'],
            'image' => $duongDanAnh,
        ]);

        return redirect()->route('posts.index')->with('success', 'Đăng bài viết thành công!');
    }

    // Form chỉnh sửa bài viết
    public function edit(Post $post)
    {
        // Đổi cách kiểm tra quyền sở hữu
        if (auth()->id() !== $post->user_id) {
            abort(403, 'Cảnh báo: Bạn không có quyền can thiệp vào bài viết này.');
        }

        $baiViet = $post;
        return view('baiviet.edit', compact('baiViet'));
    }

    // Cập nhật bài viết
    public function update(Request $request, Post $post)
    {
        if (auth()->id() !== $post->user_id) {
            abort(403, 'Cảnh báo: Bạn không có quyền can thiệp vào bài viết này.');
        }

        $duLieuSua = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:3072',
        ]);

        $duongDanAnh = $post->image;
        if ($request->hasFile('image')) {
            if ($post->image) {
                Storage::disk('public')->delete($post->image);
            }
            $duongDanAnh = $request->file('image')->store('images_baiviet', 'public');
        }

        $post->update([
            'title' => $duLieuSua['title'],
            'content' => $duLieuSua['content'],
            'image' => $duongDanAnh,
        ]);

        return redirect()->route('posts.index')->with('success', 'Cập nhật bài viết thành công!');
    }

    // Xóa bài viết
    public function destroy(Post $post)
    {
        if (auth()->id() !== $post->user_id) {
            abort(403, 'Cảnh báo: Bạn không có quyền can thiệp vào bài viết này.');
        }

        if ($post->image) {
            Storage::disk('public')->delete($post->image);
        }

        $post->delete();

        return redirect()->route('posts.index')->with('success', 'Đã xóa bài viết thành công!');
    }
}