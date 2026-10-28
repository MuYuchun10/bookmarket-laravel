<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        $name = fake()->words(3, true);

        return [
            'category_id' => Category::factory(),
            'name' => $name,
            'slug' => Str::slug($name) . '-' . fake()->unique()->numberBetween(10000, 99999),
            'author' => fake()->name(),
            'description' => fake()->sentence(15),
            'full_description' => fake()->paragraphs(3, true),
            'price' => fake()->randomFloat(2, 100, 3000),
            'image' => null,
            'quantity' => fake()->numberBetween(0, 30),
            'is_new' => fake()->boolean(30),
            'is_hit' => fake()->boolean(20),
            'status' => true,
            'publisher' => fake()->company(),
            'publication_year' => fake()->numberBetween(2000, 2026),
            'pages' => fake()->numberBetween(100, 900),
            'language' => 'Русский',
            'cover_type' => fake()->randomElement(['Твердая', 'Мягкая']),
            'article' => fake()->unique()->bothify('BK-#####'),
        ];
    }
}
