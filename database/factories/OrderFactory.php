<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition(): array
    {
        $subtotal = fake()->randomFloat(2, 500, 5000);

        return [
            'user_id' => User::factory(),
            'order_number' => 'BM-' . fake()->unique()->numerify('########'),
            'status' => 'new',
            'customer_name' => fake()->name(),
            'customer_email' => fake()->safeEmail(),
            'phone' => fake()->numerify('+7##########'),
            'city' => fake()->city(),
            'street' => fake()->streetName(),
            'house' => fake()->buildingNumber(),
            'flat' => '',
            'comment' => fake()->sentence(),
            'subtotal' => $subtotal,
            'discount' => 0,
            'total' => $subtotal,
        ];
    }
}
