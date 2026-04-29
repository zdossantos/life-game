<?php

namespace App\Providers;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\ServiceProvider;

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
        // Build the password-reset email using the locale already set on the
        // request (App::setLocale is called in PasswordResetLinkController
        // before Password::sendResetLink), so all __() calls below are
        // automatically rendered in the user's chosen language.
        ResetPassword::toMailUsing(function (object $notifiable, string $token) {
            $url = url(route('password.reset', [
                'token' => $token,
                'email' => $notifiable->getEmailForPasswordReset(),
            ], false));

            $expireMinutes = config(
                'auth.passwords.'.config('auth.defaults.passwords').'.expire'
            );

            return (new MailMessage)
                ->subject(__('passwords.email_subject'))
                ->line(__('passwords.email_intro'))
                ->action(__('passwords.email_action'), $url)
                ->line(__('passwords.email_expire', ['count' => $expireMinutes]))
                ->line(__('passwords.email_noreply'));
        });
    }
}
