<?php

namespace App\Http\Controllers;

use App\Http\Requests\ForgotPasswordRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct(
        protected AuthService $authService
    ) {}

    public function login(LoginRequest $request): JsonResponse
    {
        $data = $request->validated();

        $response = $this->authService->login($data);

        return response()->json(['data' => $response]);
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        $data = $request->validated();

        $response = $this->authService->register($data);

        return response()->json(['data' => $response], 201);
    }

    public function logout(Request $request): JsonResponse
    {
        $userId = $request->user()->id;

        $this->authService->logout($userId);

        return response()->json(['message' => 'Se ha cerrado la sesión correctamente'], 200);
    }

    public function forgotPassword(ForgotPasswordRequest $request): JsonResponse
    {
        
        $this->authService->forgotPassword($request->validated());

        return response()->json(['message' => 'Enlace de restablecimiento de contraseña enviado a su correo electrónico.']);
    }

    public function resetPassword(ResetPasswordRequest $request): JsonResponse
    {
        $data = $request->validated();

        $this->authService->resetPassword($data);

        return response()->json(['message' => 'Contraseña restablecida con éxito ']);
    }

    
}
