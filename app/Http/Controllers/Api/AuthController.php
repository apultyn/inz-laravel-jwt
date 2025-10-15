<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Services\AuthService;

class AuthController extends Controller
{
    public function __construct(private AuthService $authService)
    {
    }
    public function login(LoginRequest $request)
    {
        $token = $this->authService->loginUser($request->validated());

        if (!$token) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->authService->createNewTokenResponse($token);
    }
    public function register(RegisterRequest $request)
    {
        $user = $this->authService->registerUser($request->validated());

        return response()->json([
            'message' => 'User successfully registered',
            'user' => $user
        ], 201);
    }
}
