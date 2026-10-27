<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Khóa ngoại liên kết với bảng users
            $table->string('title');       // Tiêu đề bài viết
            $table->text('content');       // Nội dung bài viết
            $table->string('image')->nullable(); // Đường dẫn ảnh (cho phép null)
            $table->timestamps();          // created_at, updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};