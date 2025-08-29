<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    /**
     * Display the specified user.
     */
    public function show(User $user): UserResource
    {
        // finds the user or returns a 404.
        return new UserResource($user);
    }

    /**
     * Update the specified user's details in storage.
     */
    public function update(UpdateUserRequest $request, User $user): UserResource
    {
        
        $validatedData = $request->validated();
        
        $user->update($validatedData);

        return new UserResource($user);
    }

    /**
     * Soft delete the specified user.
     */
    public function destroy(User $user): JsonResponse
    {
        
        // 1. Set the user's status to 'deactivated'.
        $user->status = 'deactivated';
        $user->save();

        // 2. Perform the soft delete.
        $user->delete();

        return response()->json(['message' => 'User successfully deactivated']);
    }
}