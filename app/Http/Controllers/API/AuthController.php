<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    /**
     * Handle user registration.
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        $user = User::create([
            'user_name' => $request->user_name,
            'user_email' => $request->user_email,
            'user_password' => Hash::make($request->user_password),
            'mobile' => $request->mobile,
            'shipping_address_line_1' => $request->shipping_address_line_1,
            'shipping_address_line_2' => $request->shipping_address_line_2,
            'shipping_city' => $request->shipping_city,
            'shipping_state' => $request->shipping_state,
            'shipping_postal_code' => $request->shipping_postal_code,
            'shipping_country' => $request->shipping_country,
        ]);

        $token = $user->createToken('AppNameAuthToken')->accessToken;

        return response()->json([
            'message' => 'User registered successfully!',
            'token' => $token,
            'user' => new UserResource($user),
        ], 201);
    }

    /**
     * Handle user login.
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $credentials = [
            'user_email' => $request->user_email,
            'password' => $request->user_password,
        ];

        if (!Auth::attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized. Invalid credentials.'], 401);
        }

        $user = Auth::user();
        $token = $user->createToken('AppNameAuthToken')->accessToken;

        return response()->json([
            'message' => 'Login successful!',
            'token' => $token,
            'user' => new UserResource($user),
        ]);
    }

    /**
     * Handle user logout.
     */
    public function logout(Request $request): JsonResponse
    {
        $request->user()->token()->revoke();

        return response()->json(['message' => 'Successfully logged out']);
    }
}