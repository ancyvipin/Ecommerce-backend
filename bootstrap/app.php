<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

// --- Add these 'use' statements at the top ---
use Illuminate\Http\Request;
use Illuminate\Auth\AuthenticationException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php', // Make sure your API route file is included here
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        
        // --- 1. The Middleware Fix (Goes here) ---
        // This tells Laravel what to do when an unauthenticated user
        // tries to access a protected route.
        $middleware->redirectGuestsTo(function (Request $request) {
            // If the request is for an API endpoint...
            if ($request->is('api/*')) {
                // ...do not redirect. Instead, return null, which will
                // trigger an AuthenticationException.
                return null;
            }

            // For any other (web) request, redirect to the login route.
            return route('login');
        });

    })
    ->withExceptions(function (Exceptions $exceptions) {
        
        // --- 2. The Exception Fix (Goes here) ---
        // This catches the AuthenticationException that the middleware
        // now throws for unauthenticated API requests.
        $exceptions->render(function (AuthenticationException $e, Request $request) {
            // If the request is for an API endpoint...
            if ($request->is('api/*')) {
                // ...return a clean JSON response with a 401 status code.
                return response()->json(['message' => 'Unauthenticated.'], 401);
            }
        });

    })->create();