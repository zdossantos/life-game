<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Passport\Passport;

uses(RefreshDatabase::class);

test('a user can logout with a valid token', function () {
    $user = User::factory()->create();
    Passport::actingAs($user);

    $response = $this->postJson('/api/auth/logout');

    $response->assertStatus(200)
        ->assertJson(['status' => 'success']);
});

test('logout returns 401 when no token is provided', function () {
    $response = $this->postJson('/api/auth/logout');

    $response->assertStatus(401);
});
