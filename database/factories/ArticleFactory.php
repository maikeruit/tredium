<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ArticleFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(),
            'cover_image' => fake()->imageUrl(640, 480),
            'content' => fake()->paragraphs(3, true),
        ];
    }
} 