<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Validation\ValidationException;

class EmailVerificationService
{
    
    public function sendEmail(int $userId): void
    {
        $user = User::find($userId);

        if (!$user) {
            throw ValidationException::withMessages(['email' => ['El usuario no existe.']]);
        }

        if ($user->hasVerifiedEmail()) {
            throw ValidationException::withMessages(['email' => ['El correo electrónico ya está verificado.']]);
        }

        $user->sendEmailVerificationNotification();
    }

    public function verifyEmail(string $token): void
    {
        $userId = Cache::pull('email_verification_' . $token);

        if (!$userId) {
            throw ValidationException::withMessages(['token' => ['El token de verificación es inválido.']]);
        }

        $user = User::find($userId);

        if (!$user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();
        }
    }
}
