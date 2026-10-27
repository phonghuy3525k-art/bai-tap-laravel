<?php

namespace Database\Factories;

use App\Models\Comment;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Comment>
 */
class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
   public function definition(): array
{
    return [
        'post_id' => \App\Models\Post::factory(), // Tự động tạo post
        'user_id' => \App\Models\User::factory(), // Tự động tạo user
        'content' => fake()->sentence(),
    ];
}
}
