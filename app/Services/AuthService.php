<?php

namespace App\Services;

use App\Models\User;
use App\Enums\UserRole;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    public function registerUser(array $validatedData): User
    {
        $user =  User::create([
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
        ]);

        $user->assignRole("BOOK_USER");

        return $user;
    }
    public function loginUser(array $credentials): ?string
    {
        if (!$token = auth('api')->attempt($credentials)) {
            return null;
        }

        return $token;
    }

    public function createNewTokenResponse(string $token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60,
            'user' => auth('api')->user()
        ]);
    }
}