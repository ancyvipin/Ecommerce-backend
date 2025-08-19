<?php

namespace App\Http\Controllers\API;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\FrequencyReportRequest;
use Illuminate\Support\Facades\DB;
class RefillController extends Controller
{
     public function productsToRefill()
    {
        // Use whereColumn to efficiently compare two columns from the same table.
        $products = Product::whereColumn('stock_quantity', '<=', 'refill_prdts')->get();

        return ProductResource::collection($products);
    }

    public function frequentlyPurchased(FrequencyReportRequest $request)
    {
        $validated = $request->validated();
        $limit = $validated['limit'] ?? 10; // Default to top 10 if not provided

        $query = DB::table('order_items')
            // Join with orders to filter by the order date
            ->join('orders', 'order_items.order_id', '=', 'orders.order_id')
            // Join with products to get product details
            ->join('products', 'order_items.prdt_id', '=', 'products.prdt_id')
            // Select the product details and the calculated sum
            ->select(
                'products.prdt_id',
                'products.prdt_name',
                DB::raw('SUM(order_items.item_quantity) as total_quantity_sold')
            )
            // Ensure we are not including items from soft-deleted orders
            ->whereNull('orders.deleted_at');

        // Conditionally apply the date filters
        if (isset($validated['from_date'])) {
            $query->whereDate('orders.created_at', '>=', $validated['from_date']);
        }
        if (isset($validated['to_date'])) {
            $query->whereDate('orders.created_at', '<=', $validated['to_date']);
        }

        // Group by product to aggregate the quantities, then sort and limit
        $frequentProducts = $query->groupBy('products.prdt_id', 'products.prdt_name')
            ->orderBy('total_quantity_sold', 'desc')
            ->limit($limit)
            ->get();

        return response()->json($frequentProducts);
    }


}
