<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Http\Resources\ProductResource;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return ProductResource::collection(Product::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
       // Laravel automatically validates the request. If it fails, a 422 response is sent.
        // $request->validated() returns an array of the validated data.
        $product = Product::create($request->validated());

        // Return the newly created product, formatted by the resource.
        return new ProductResource($product);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
       return new ProductResource($product);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        // The request is validated, and the product model is already fetched.
        // We get the validated data to safely update the model.
        $validatedData = $request->validated();
        
        $product->update($validatedData);

        // Return the updated product resource.
        return new ProductResource($product);
    }


    /**
     * Remove the specified resource from storage.
     */
   public function destroy(Product $product)
    {
        // The product model is already fetched.
        // You could add extra authorization here if needed.
        // e.g., if ($request->user()->cannot('delete', $product)) { abort(403); }

        $product->delete();

        // Return a confirmation response with a 200 OK status.
        return response()->json(['message' => 'Product deleted successfully.'], 200);
    }
}
