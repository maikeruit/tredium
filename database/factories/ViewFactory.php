<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ViewFactory extends Factory
{
    public function definition(): array
    {
        return [
            'count' => fake()->numberBetween(0, 5000),
        ];
    }
} 