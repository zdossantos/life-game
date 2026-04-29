<?php

use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Password;

uses(RefreshDatabase::class);

test('reset password link screen can be rendered', function () {
    $response = $this->get('/forgot-password');

    $response->assertStatus(200);
});

test('reset password link can be requested', function () {
    Notification::fake();

    $user = User::factory()->create();

    $this->post('/forgot-password', ['email' => $user->email]);

    Notification::assertSentTo($user, ResetPassword::class);
});

test('reset password screen can be rendered', function () {
    Notification::fake();

    $user = User::factory()->create();

    $this->post('/forgot-password', ['email' => $user->email]);

    Notification::assertSentTo($user, ResetPassword::class, function ($notification) {
        $response = $this->get('/reset-password/'.$notification->token);

        $response->assertStatus(200);

        return true;
    });
});

test('password can be reset with valid token', function () {
    Notification::fake();

    $user = User::factory()->create();

    $this->post('/forgot-password', ['email' => $user->email]);

    Notification::assertSentTo($user, ResetPassword::class, function ($notification) use ($user) {
        $response = $this->post('/reset-password', [
            'token' => $notification->token,
            'email' => $user->email,
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect(route('login'));

        return true;
    });
});

test('forgot password redirects to password.request route on success', function () {
    Notification::fake();

    $user = User::factory()->create();

    $this->post('/forgot-password', ['email' => $user->email])
        ->assertRedirect(route('password.request'))
        ->assertSessionHas('status');
});

test('forgot password with fr locale sends email with French subject', function () {
    Notification::fake();

    $user = User::factory()->create();

    $this->post('/forgot-password', [
        'email'  => $user->email,
        'locale' => 'fr',
    ]);

    Notification::assertSentTo($user, ResetPassword::class, function ($notification) use ($user) {
        App::setLocale('fr');
        $mail = $notification->toMail($user);

        expect($mail->subject)->toBe('Réinitialisation de votre mot de passe');

        return true;
    });
});

test('forgot password with en locale sends email with English subject', function () {
    Notification::fake();

    $user = User::factory()->create();

    $this->post('/forgot-password', [
        'email'  => $user->email,
        'locale' => 'en',
    ]);

    Notification::assertSentTo($user, ResetPassword::class, function ($notification) use ($user) {
        App::setLocale('en');
        $mail = $notification->toMail($user);

        expect($mail->subject)->toBe('Reset Password');

        return true;
    });
});

test('forgot password returns validation error when throttled', function () {
    Password::shouldReceive('sendResetLink')
        ->once()
        ->andReturn(Password::RESET_THROTTLED);

    $this->post('/forgot-password', ['email' => 'test@example.com'])
        ->assertSessionHasErrors('email');
});
