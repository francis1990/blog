<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Francis User',
            'email' => 'fcobas@mailinator.com',
            'password' => bcrypt('password')
        ]);

        Category::factory(10)->create();
        Post::factory(100)->create();
    }
}
