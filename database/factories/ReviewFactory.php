<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReviewFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::inRandomOrder()->first()?->id ?? User::factory(),
            'product_id' => Product::inRandomOrder()->first()?->id ?? Product::factory(),
            'rating' => fake()->numberBetween(4, 5),
            'comment' => fake()->sentence(12),
            'status' => true,
        ];
    }
}