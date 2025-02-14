<?php

namespace App\Providers;

use App\Models\User;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

        ResetPassword::createUrlUsing(function (User $user, string $token) {

            return config('app.frontend_url') . '/reset-password?token=' .  $token . '&email=' . $user->email;
        });

        VerifyEmail::createUrlUsing(function (User $user) {

            $token = Str::random(60);

            Cache::put('email_verification_' . $token, $user->id, now()->addHour());

            return config('app.frontend_url') . '/email/verify?token=' . $token;
        });
    }
}
