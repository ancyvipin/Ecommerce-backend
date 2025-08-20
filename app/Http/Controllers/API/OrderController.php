<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequest; // <-- Use our powerful request
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Create a new order from the user's cart.
     */
    public function store(OrderRequest $request): OrderResource|JsonResponse
    {
        // At this point, validation has passed. We know:
        // - The user is authenticated.
        // - The cart is not empty.
        // - All product_ids exist.
        // - All quantities are valid integers >= 1.
        // - There is sufficient stock for every item.
        $cartItems = $request->validated()['cart'];
        $user = $request->user();

        try {
            // A transaction is still crucial for data integrity.
            $order = DB::transaction(function () use ($user, $cartItems) {
                // --- THIS IS WHERE TOTAL AMOUNT IS CALCULATED ---

                // 1. Fetch all products at once to be efficient.
                $productIds = array_column($cartItems, 'product_id');
                $products = Product::findMany($productIds)->keyBy('prdt_id');

                // 2. Calculate the total amount.
                $totalAmount = 0;
                foreach ($cartItems as $item) {
                    $product = $products->get($item['product_id']);
                    $totalAmount += $product->prdt_price * $item['quantity'];
                }

                // 3. Create the Order with the calculated total.
                $order = Order::create([
                    'user_id'      => $user->user_id, // Make sure 'user_id' is the primary key on your User model
                    'total_amount' => $totalAmount,
                    'status'       => 'pending',
                ]);

                // 4. Prepare and create Order Items, then update stock.
                foreach ($cartItems as $item) {
                    $product = $products->get($item['product_id']);
                    
                    // Create the associated order item
                    $order->items()->create([
                        'prdt_id'       => $product->prdt_id,
                        'item_quantity' => $item['quantity'],
                        'item_price'    => $product->prdt_price, // Lock price at time of purchase
                    ]);

                    // Decrement stock safely. This is the final step.
                    $product->decrement('stock_quantity', $item['quantity']);
                }
                
                return $order;
            });

            // Eager load the relationships for the response
            return new OrderResource($order->load('items.product'));

        } catch (\Exception $e) {
            // This will catch any unexpected database or other errors.
            return response()->json(['message' => 'An unexpected error occurred while placing your order.'], 500);
        }
    }
     public function destroy(Order $order): JsonResponse
    {
        

        // --- Important Business Logic ---
        // When an order is cancelled, we should return the purchased items back to stock.
        // A transaction ensures this happens safely.
        DB::transaction(function () use ($order) {
            // 1. Restore stock for each item in the order.
            foreach ($order->items as $item) {
                Product::find($item->prdt_id)->increment('stock_quantity', $item->item_quantity);
            }

            // 2. You might want to update the order's status to 'cancelled'.
            $order->status = 'cancelled';
            $order->save();

            // 3. Perform the soft delete.
            // The SoftDeletes trait ensures this sets the `deleted_at` timestamp.
            $order->delete();
        });

        return response()->json(['message' => 'Order successfully cancelled.']);
    }
}