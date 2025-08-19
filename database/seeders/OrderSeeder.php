<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        // We need existing users and products to create orders
        $users = User::all();
        $products = Product::all();

        if ($users->isEmpty() || $products->isEmpty()) {
            $this->command->error('Cannot seed orders. Please seed users and products first.');
            return;
        }

        DB::transaction(function () use ($users, $products) {
            Order::factory(100)->make()->each(function ($order) use ($users, $products) {
                // ... same logic from DatabaseSeeder to create orders and items ...
                $order->user_id = $users->random()->user_id;
                $order->save();
                
                $orderItems = OrderItem::factory(rand(1, 5))->make();
                $orderTotal = 0;

                foreach ($orderItems as $item) {
                    $product = $products->random();
                    if ($product->stock_quantity >= $item->item_quantity) {
                        $item->order_id = $order->order_id;
                        $item->prdt_id = $product->prdt_id;
                        $item->item_price = $product->prdt_price;
                        $item->save();
                        $orderTotal += $item->item_price * $item->item_quantity;
                        $product->decrement('stock_quantity', $item->item_quantity);
                    }
                }
                $order->total_amount = $orderTotal;
                $order->save();
            });
        });
        
        $this->command->info('Seeded 100 new orders.');
    }
}