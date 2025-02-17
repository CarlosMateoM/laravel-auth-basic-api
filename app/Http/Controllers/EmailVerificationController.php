<?php

namespace App\Http\Controllers;

use App\Services\EmailVerificationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class EmailVerificationController extends Controller
{

    public function __construct(
        private EmailVerificationService $authService
    ) {}

    public function verifyEmail(Request $request): JsonResponse
    {
        $this->authService->verifyEmail($request->token);

        return response()->json(['message' => 'email verified successfully']);
    }

    public function sendEmail(Request $request): JsonResponse
    {
        $this->authService->sendEmail($request->user()->id);

        return response()->json(['message' => 'email verification link sent on your email']);
    }
}
