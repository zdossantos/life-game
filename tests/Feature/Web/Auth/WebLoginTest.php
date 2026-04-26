<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('the login page can be rendered', function () {
    $this->withoutVite();
    $response = $this->get('/login');

    $response->assertStatus(200);
});

test('a user can login via the login form', function () {
    $user = User::factory()->create();

    $response = $this->post('/login', [
        'email' => $user->email,
        'password' => 'password',
    ]);

    $this->assertAuthenticated();
    $response->assertRedirect(route('dashboard', absolute: false));
});

test('user is redirected to dashboard after login', function () {
    $user = User::factory()->create();

    $this->post('/login', [
        'email' => $user->email,
        'password' => 'password',
    ])->assertRedirect(route('dashboard', absolute: false));
});

test('login fails with invalid credentials', function () {
    $user = User::factory()->create();

    $this->post('/login', [
        'email' => $user->email,
        'password' => 'wrong-password',
    ]);

    $this->assertGuest();
});

test('an already authenticated user is redirected away from the login page', function () {
    $user = User::factory()->create();

    $this->actingAs($user)->get('/login')->assertRedirect(route('dashboard', absolute: false));
});
