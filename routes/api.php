<<<<<<< HEAD
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
//Route::get('/products', [ProductController::class, 'index']);

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
=======
<?php

use App\Http\Controllers\API\OrderController;
use App\Http\Controllers\API\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\RefillController;


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

    // It automatically creates all the necessary endpoints for the controller.
    Route::apiResource('products', ProductController::class);

    // Order routes
    Route::post('/orders', [OrderController::class, 'store']);
    Route::get('/orders', [OrderController::class, 'index']);
    Route::get('/orders/{order}',[OrderController::class,'show']);
    Route::put('/orders/{order}',[OrderController::class,'update']);
    Route::delete('/orders/{order}',[OrderController::class,'destroy']);


    // --- Refill and Frequency check Routes ---
Route::get('/reports/products-to-refill', [RefillController::class, 'productsToRefill']);
Route::get('/reports/frequently-purchased', [RefillController::class, 'frequentlyPurchased']);
});
>>>>>>> 141a7ee (Updated project with new controllers, requests, factories, and migrations)
