<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('order_items', function (Blueprint $table) {
            // It's best practice to name all primary keys 'id' for consistency.
            $table->uuid('item_id')->primary();

            // --- Product Link ---
            // Assumes your products table has a UUID primary key named 'prdt_id'
            $table->uuid('prdt_id');
            $table->foreign('prdt_id')->references('prdt_id')->on('products')->onDelete('cascade');

            // --- Order Link (THE FIX IS HERE) ---
            // 1. Define the column that will hold the order's key
            $table->uuid('order_id');
            // 2. Tell it to reference the 'id' column on the 'orders' table.
            $table->foreign('order_id')->references('order_id')->on('orders')->onDelete('cascade');

            $table->integer('item_quantity');
            $table->decimal('item_price', 8, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
