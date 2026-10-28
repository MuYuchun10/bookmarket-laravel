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
        $admin = User::updateOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'name' => 'Администратор',
                'password' => Hash::make('admin123'),
                'phone' => '+7 900 000-00-00',
                'city' => 'Орёл',
                'address' => 'ул. Ленина, 1',
                'postcode' => '302000',
            ]
        );
        $admin->role = 'admin';
        $admin->save();

        // Тестовый обычный покупатель
        $user = User::updateOrCreate(
            ['email' => 'user@user.com'],
            [
                'name' => 'Иван Иванов',
                'password' => Hash::make('password'),
                'phone' => '+7 999 111-22-33',
                'city' => 'Москва',
                'address' => 'ул. Тверская, 10',
                'postcode' => '101000',
            ]
        );
        $user->role = 'user';
        $user->save();
    }
}