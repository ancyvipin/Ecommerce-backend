<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\User;
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
                'order_id' => Str::uuid(),
                // We link to a user that MUST exist. The seeder will handle this.
                'user_id' => User::factory(),
                // We'll calculate the real total in the seeder.
                'total_amount' => fake()->randomFloat(2, 50, 2000),
                'status' => fake()->randomElement(['pending', 'processing', 'shipped', 'completed']),
                'user_status_at_order' => 'active',
            ];
    }
}
