<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('accessing a protected route without a token returns 401', function () {
    $protectedRoutes = [
        ['method' => 'post', 'uri' => '/api/auth/logout'],
        ['method' => 'get', 'uri' => '/api/auth/me'],
    ];

    foreach ($protectedRoutes as $route) {
        $response = $this->{$route['method'].'Json'}($route['uri']);
        $response->assertStatus(401, "Expected 401 for {$route['method']} {$route['uri']}");
    }
});
