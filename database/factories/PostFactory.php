<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\User;
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
            'title'=> $this->faker->sentence(),
            'slug'=> $this->faker->unique()->slug(),
            'excerpt'=> $this->faker->paragraph(),
            'content'=> $this->faker->paragraph(20),
            'is_published'=> $this->faker->boolean(),
            'published_at'=> $this->faker->dateTime(),
            'user_id'=> User::all()->random()->id,
            'category_id'=> Category::all()->random()->id,
        ];
    }
}
