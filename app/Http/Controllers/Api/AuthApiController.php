<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LoginApiRequest;
use App\Http\Requests\Api\RegisterApiRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthApiController extends Controller
{
    /**
     * Register a new user and return an API token.
     */
    public function register(RegisterApiRequest $request): JsonResponse
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = $user->createToken('api-token')->accessToken;

        return response()->json([
            'status' => 'success',
            'message' => 'User registered successfully.',
            'data' => [
                'user' => $user,
                'token' => $token,
            ],
        ], 201);
    }

    /**
     * Authenticate a user and return an API token.
     */
    public function login(LoginApiRequest $request): JsonResponse
    {
        if (! Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid credentials.',
                'data' => null,
            ], 401);
        }

        /** @var User $user */
        $user = Auth::user();
        $token = $user->createToken('api-token')->accessToken;

        return response()->json([
            'status' => 'success',
            'message' => 'Login successful.',
            'data' => [
                'user' => $user,
                'token' => $token,
            ],
        ]);
    }

    /**
     * Revoke the current user's token.
     */
    public function logout(Request $request): JsonResponse
    {
        $request->user()->token()->revoke();

        return response()->json([
            'status' => 'success',
            'message' => 'Logged out successfully.',
            'data' => null,
        ]);
    }

    /**
     * Return the authenticated user's profile.
     */
    public function me(Request $request): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'message' => 'User retrieved successfully.',
            'data' => [
                'user' => $request->user(),
            ],
        ]);
    }
}
