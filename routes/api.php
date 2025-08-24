<?php

use App\Http\Controllers\API\OrderController;
use App\Http\Controllers\API\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;



// NOTE: You will need to create AuthController for register/login

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Public routes
 Route::get('/products', [ProductController::class, 'index']);

    // Protected routes (require authentication)
    Route::middleware('auth:api')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    // --- THIS IS THE ROUTE FOR YOUR PRODUCT CRUD ---
    // It automatically creates all the necessary endpoints for the controller.
    Route::apiResource('products', ProductController::class);

    // Order routes
    Route::post('/orders', [OrderController::class, 'store']);
    Route::get('/orders', [OrderController::class, 'index']);
});
