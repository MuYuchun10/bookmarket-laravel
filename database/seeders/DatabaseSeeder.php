<?php

namespace Database\Seeders;

use App\Models\Review;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            CategorySeeder::class,
            ProductSeeder::class,
        ]);

        // Генерируем 15 случайных отзывов к книгам
        Review::factory(15)->create();
    }
}