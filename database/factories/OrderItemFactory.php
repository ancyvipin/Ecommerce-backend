<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\order;
use App\Models\Product;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OrderItem>
 */
class OrderItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'item_id' => Str::uuid(),
            'order_id' => Order::factory(),
            'prdt_id' => Product::factory(),
            'item_quantity' => fake()->numberBetween(1, 5),
            // We set the price to 0 here; the seeder will set the actual price at time of purchase.
            'item_price' => 0,
        ];
    }
}
