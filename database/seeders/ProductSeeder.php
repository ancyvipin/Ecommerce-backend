<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::factory(50)->create();
        Product::factory(5)->create([
            'stock_quantity' => 5,
            'refill_prdts' => 10,
        ]);
        $this->command->info('Seeded 55 new products.');
    }
}
