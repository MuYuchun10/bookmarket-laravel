<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 10 тестовых пользователей
        for ($i = 1; $i <= 10; $i++) {
            $email = "demo{$i}@example.test";

            if (!User::where('email', $email)->exists()) {
                User::factory()->create([
                    'email' => $email,
                ]);
            }
        }

        // Учетная запись администратора
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
    }
}