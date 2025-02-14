<?php

namespace App\Services;

use App\Http\Resources\UserResource;
use App\Models\User;
use Exception;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;


class AuthService
{

    public function register(array $data): array
    {
        $user = User::create([
            'name'      => $data['name'],
            'email'     => $data['email'],
            'password'  => $data['password']
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        event(new Registered($user));

        return [
            'user'  => $user,
            'token' => $token,
        ];
    }

    public function login(array $data): array
    {
        if (!Auth::attempt($data)) {
            throw ValidationException::withMessages([
                'email' => ['Las credenciales no coinciden con nuestros registros.'],
            ]);
        }

        $user = User::where('email', $data['email'])->first();

        $token = $user->createToken('auth_token')->plainTextToken;

        return [
            'user' => $user,
            'token' => $token,
        ];
    }

    public function logout(int $userId): void
    {
        $user = User::find($userId);

        $user->tokens()->delete();
    }

    public function forgotPassword(array $data): void
    {
        $status = Password::sendResetLink($data);

        if ($status === Password::INVALID_USER) {
            throw ValidationException::withMessages([
                'email' => ['El usuario no existe.'],
            ]);
        }

        if ($status === Password::RESET_THROTTLED) {
            throw ValidationException::withMessages([
                'email' => ['Demasiados intentos. Intenta de nuevo en un minuto.'],
            ]);
        }

        if ($status !== Password::RESET_LINK_SENT) {
            throw new Exception('Error sending email');
        }
    }

    public function resetPassword(array $data): void
    {
        $status = Password::reset(
            $data,
            function (User $user, string $password) {

                $user->tokens()->delete();

                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                //event(new PasswordReset($user));

                Log::info("Contraseña restablecida para el usuario: {$user->email}");
            }
        );

        if ($status === Password::RESET_THROTTLED) {
            throw ValidationException::withMessages([
                'email' => ['Demasiados intentos. Intenta de nuevo en un minuto.'],
            ]);
        }

        if ($status === Password::INVALID_TOKEN) {
            throw ValidationException::withMessages(['token' => 'El token de es inválido.']);
        }

        if ($status === Password::INVALID_USER) {
            throw ValidationException::withMessages([
                'email' => ['El usuario no existe.'],
            ]);
        }

        if ($status !== Password::PASSWORD_RESET) {
            throw new Exception('No se pudo restablecer la contraseña. Intenta de nuevo.');
        }
    }
}
