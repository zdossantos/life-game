<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Passport\Passport;

uses(RefreshDatabase::class);

test('an authenticated user can retrieve their profile', function () {
    $user = User::factory()->create();
    Passport::actingAs($user);

    $response = $this->getJson('/api/auth/me');

    $response->assertStatus(200)
        ->assertJsonStructure([
            'status',
            'message',
            'data' => [
                'user' => ['id', 'name', 'email'],
            ],
        ])
        ->assertJson([
            'status' => 'success',
            'data' => [
                'user' => [
                    'id' => $user->id,
                    'email' => $user->email,
                ],
            ],
        ]);
});

test('retrieving profile returns 401 when no token is provided', function () {
    $response = $this->getJson('/api/auth/me');

    $response->assertStatus(401);
});
