<?php

use App\Http\Controllers\API\OrderController;
use App\Http\Controllers\API\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API;


// NOTE: You will need to create AuthController for register/login

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Public routes
//Route::get('/products', [ProductController::class, 'index']);

    // Protected routes (require authentication)
    Route::middleware('auth:api')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    // --- User Management Routes ---
    Route::get('/users/{user}', [UserController::class, 'show']);
    Route::put('/users/{user}', [UserController::class, 'update']);
    Route::delete('/users/{user}', [UserController::class, 'destroy']); // Soft delete

    // --- Refill and Frequency check Routes ---
Route::get('/products/reports/products-to-refill', [ProductController::class, 'productsToRefill']);
Route::get('/products/reports/frequently-purchased', [ProductController::class, 'frequentlyPurchased']);

    // It automatically creates all the necessary endpoints for the controller.
    Route::apiResource('products', ProductController::class);

    // Order routes
    Route::post('/orders', [OrderController::class, 'store']);
    Route::get('/orders', [OrderController::class, 'index']);
    Route::get('/orders/{order}',[OrderController::class,'show']);
    Route::put('/orders/{order}',[OrderController::class,'update']);
    Route::delete('/orders/{order}',[OrderController::class,'destroy']);
    Route::delete('/orders/{order}/item/{item}',[OrderController::class,'destroyItem']);
    
});
