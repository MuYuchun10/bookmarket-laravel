<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['id' => 1, 'name' => 'Художественная литература', 'slug' => 'fiction', 'description' => 'Романы, классика и современная проза.'],
            ['id' => 2, 'name' => 'Фэнтези', 'slug' => 'fantasy', 'description' => 'Книги о магии, приключениях и вымышленных мирах.'],
            ['id' => 3, 'name' => 'Детективы', 'slug' => 'detective', 'description' => 'Истории расследований, загадок и неожиданных развязок.'],
            ['id' => 4, 'name' => 'Учебная литература', 'slug' => 'study', 'description' => 'Книги для учебы, программирования и профессионального развития.'],
            ['id' => 5, 'name' => 'Бизнес', 'slug' => 'business', 'description' => 'Издания о предпринимательстве, управлении и финансах.'],
            ['id' => 6, 'name' => 'Саморазвитие', 'slug' => 'self-development', 'description' => 'Практичные книги о привычках, мышлении и личной эффективности.'],
            ['id' => 7, 'name' => 'Научная фантастика', 'slug' => 'sci-fi', 'description' => 'Фантастические истории о технологиях, будущем и космосе.'],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(['id' => $category['id']], $category);
        }
    }
}