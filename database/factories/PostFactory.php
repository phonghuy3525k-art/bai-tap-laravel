<?php

namespace Database\Factories;

use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
   public function definition(): array
{
    return [
        'user_id' => \App\Models\User::factory(), // Tự động tạo user nếu chưa có
        'title' => fake()->sentence(),
        'content' => fake()->paragraphs(3, true),
        'image' => 'posts/sample.jpg', // Tên ảnh mẫu
    ];
}
}
