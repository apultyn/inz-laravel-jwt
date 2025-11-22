<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthService
{
    public function registerUser(array $validatedData): User
    {
        $user = User::create([
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
        ]);

        $user->assignRole("BOOK_USER");

        return $user;
    }
    public function loginUser(array $credentials): ?string
    {
        $token = Auth::guard()->attempt($credentials);
        if (!$token) {
            return null;
        }

        return $token;
    }

    public function createNewTokenResponse(string $token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Auth::factory()->getTTL() * 60,
            'user' => Auth::guard()->user(),
        ]);
    }
}