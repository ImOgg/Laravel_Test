<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Post;

class PostFactory extends Factory
{
    protected $model = Post::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->sentence(3),
            'author' => $this->faker->name,
            'content' => $this->faker->paragraph,
        ];
    }
}
