<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('an authenticated user can logout', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post('/logout');

    $this->assertGuest();
    $response->assertRedirect('/');
});

test('the session is destroyed after logout', function () {
    $user = User::factory()->create();

    $this->actingAs($user)->post('/logout');

    $this->assertGuest();
});
