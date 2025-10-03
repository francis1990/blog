<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\User;
use App\ValueObjects\PostStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
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
            'title' => $this->faker->sentence,
            'slug' => $this->faker->slug,
            'content' => $this->faker->paragraph,
            'excerpt' => $this->faker->text(100),
            'status' => PostStatus::DRAFT,
            'category_id' => Category::factory(),
            'user_id' => User::factory(),
            'image_path' => null,
            'published_at' => null,
        ];
    }
}
