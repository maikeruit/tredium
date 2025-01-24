<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ArticleFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(),
            'cover_image' => 'https://images.unsplash.com/photo-1682685796014-2f342188a635?w=640&h=480',
            'content' => fake()->paragraphs(3, true),
        ];
    }
}
