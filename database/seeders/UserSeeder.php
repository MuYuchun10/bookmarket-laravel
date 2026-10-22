<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Учетная запись администратора из старого дампа
        User::updateOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'name' => 'Администратор',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'phone' => '+7 900 000-00-00',
                'city' => 'Орёл',
                'address' => 'ул. Ленина, 1',
                'postcode' => '302000',
            ]
        );

        // Тестовый обычный покупатель
        User::updateOrCreate(
            ['email' => 'user@user.com'],
            [
                'name' => 'Иван Иванов',
                'password' => Hash::make('password'),
                'role' => 'user',
                'phone' => '+7 999 111-22-33',
                'city' => 'Москва',
                'address' => 'ул. Тверская, 10',
                'postcode' => '101000',
            ]
        );
    }
}