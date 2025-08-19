<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $stock = fake()->numberBetween(5, 200);
        return [
            'prdt_id' => Str::uuid(),
        'prdt_name' => fake()->words(3, true), // e.g., "sleek cotton chair"
        'prdt_description' => fake()->paragraph(),
        'prdt_price' => fake()->randomFloat(2, 10, 500), // 2 decimals, min 10, max 500
        'stock_quantity' => $stock,
        // Set a threshold that is a fraction of the stock for realistic data
        'refill_prdts' => fake()->numberBetween(10, 25),
        ];
    }
}
