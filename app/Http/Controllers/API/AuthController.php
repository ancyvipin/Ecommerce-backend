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
use function Laravel\Prompts\password;

class AuthController extends Controller
{
    /**
     * Handle user registration.
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        $validatedData=$request->validated();

        $user = User::create([
            'user_name' => $validatedData['user_name'],
            'user_email' => $validatedData['user_email'],
            'user_password' => Hash::make($validatedData['user_password']),
            'mobile' => $validatedData['mobile'],
        'shipping_address_line_1' => $validatedData['shipping_address_line_1'],
        // Use array_key_exists for optional fields like this
        'shipping_address_line_2' => array_key_exists('shipping_address_line_2', $validatedData) ? $validatedData['shipping_address_line_2'] : null,
        'shipping_city' => $validatedData['shipping_city'],
        'shipping_state' => $validatedData['shipping_state'],
        'shipping_postal_code' => $validatedData['shipping_postal_code'],
        'shipping_country' => $validatedData['shipping_country'],
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

        $validated =$request->validated();
        $credentials =$request->validated();
        $credentials=['user_email' => $validated['user_email'],
        'password'=> $validated['user_password'],];

        if (!Auth::attempt($credentials)) {
            return response()->json(['error' => 'password incorrect.'], 401);
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