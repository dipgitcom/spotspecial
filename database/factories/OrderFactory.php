<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => \App\Models\User::inRandomOrder()->first()->id ?? 1,
            'product_id' => \App\Models\Product::inRandomOrder()->first()->id ?? 1,
            'inventory_id' => \App\Models\Inventory::inRandomOrder()->first()->id ?? 1,
            'order_number' => 'ORD-' . $this->faker->unique()->numerify('#####'),
            'placed_at' => $this->faker->dateTimeBetween('-1 month', 'now'),
            'delivered_at' => $this->faker->optional()->dateTimeBetween('now', '+1 week'),
            'total_amount' => $this->faker->randomFloat(2, 100, 1000),
            'payment_status' => $this->faker->randomElement(['pending', 'completed', 'failed']),
            'payment_method' => $this->faker->randomElement(['cash', 'credit_card', 'paypal']),
            'status' => $this->faker->randomElement(['pending', 'processing', 'completed', 'cancelled']),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
