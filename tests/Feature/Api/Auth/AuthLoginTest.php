<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Passport\ClientRepository;

uses(RefreshDatabase::class);

beforeEach(function () {
    app(ClientRepository::class)->createPersonalAccessGrantClient('Test Personal Access Client');
});

test('a user can login with valid credentials and receives a token', function () {
    $user = User::factory()->create(['password' => bcrypt('password123')]);

    $response = $this->postJson('/api/auth/login', [
        'email' => $user->email,
        'password' => 'password123',
    ]);

    $response->assertStatus(200)
        ->assertJsonStructure([
            'status',
            'message',
            'data' => [
                'user' => ['id', 'name', 'email'],
                'token',
            ],
        ])
        ->assertJson(['status' => 'success']);

    expect($response->json('data.token'))->not->toBeEmpty();
});

test('login fails with a wrong password', function () {
    $user = User::factory()->create();

    $response = $this->postJson('/api/auth/login', [
        'email' => $user->email,
        'password' => 'wrong-password',
    ]);

    $response->assertStatus(401)
        ->assertJson(['status' => 'error']);
});

test('login fails when user does not exist', function () {
    $response = $this->postJson('/api/auth/login', [
        'email' => 'nobody@example.com',
        'password' => 'password123',
    ]);

    $response->assertStatus(401)
        ->assertJson(['status' => 'error']);
});
