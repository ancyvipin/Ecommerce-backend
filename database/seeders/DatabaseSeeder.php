<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
     public function run(): void
    {
        // This method calls your other seeder classes.
        // The order is important! You need users and products before you can create orders.
        $this->call([
            UserSeeder::class,
            ProductSeeder::class,
            OrderSeeder::class,
        ]);
    }

}
