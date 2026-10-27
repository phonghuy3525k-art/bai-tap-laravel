<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Post;
use App\Models\Comment;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Tạo 10 Users
        for ($i = 1; $i <= 10; $i++) {
            $user = User::create([
                'name' => 'Thành viên ' . $i,
                'email' => 'user' . $i . '@gmail.com',
                'password' => Hash::make('12345678'),
            ]);

            // 2. Mỗi user tạo 2 Posts
            for ($j = 1; $j <= 2; $j++) {
                $post = Post::create([
                    'user_id' => $user->id,
                    'title' => 'Bài viết thú vị số ' . $i . '-' . $j,
                    'content' => 'Nội dung chi tiết của bài viết mẫu được chia sẻ trên hệ thống blog cá nhân.',
                ]);

                // 3. Mỗi post tạo 2 Comments
                for ($k = 1; $k <= 2; $k++) {
                    Comment::create([
                        'post_id' => $post->id,
                        'user_id' => $user->id, // Bổ sung user_id cho comment
                        'content' => 'Bình luận số ' . $k . ' cho bài viết tuyệt vời này!', // Sửa 'body' thành 'content'
                    ]);
                }
            }
        }
    }
}