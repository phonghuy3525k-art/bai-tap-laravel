<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Seed bảng Users (10 bản ghi)
        $userIds = [];
        for ($i = 1; $i <= 10; $i++) {
            $userIds[] = DB::table('users')->insertGetId([
                'name' => "Người dùng $i",
                'email' => "user$i@example.com",
                'password' => Hash::make('password123'),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // 2. Seed bảng Posts (10 bản ghi, liên kết với users)
        $postIds = [];
        for ($i = 1; $i <= 10; $i++) {
            $postIds[] = DB::table('posts')->insertGetId([
                'user_id' => $userIds[array_rand($userIds)],
                'title' => "Tiêu đề bài viết số $i",
                'content' => "Nội dung chi tiết cho bài viết số $i thuộc hệ thống.",
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // 3. Seed bảng Comments (10 bản ghi, liên kết với posts)
        for ($i = 1; $i <= 10; $i++) {
            DB::table('comments')->insert([
                'post_id' => $postIds[array_rand($postIds)],
                'author_name' => "Khách bình luận $i",
                'content' => "Bình luận số $i: Bài viết rất hữu ích!",
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}