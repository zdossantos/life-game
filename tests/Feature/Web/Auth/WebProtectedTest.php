<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('unauthenticated users are redirected to the login page when accessing the dashboard', function () {
    $this->get('/dashboard')->assertRedirect('/login');
});

test('unauthenticated users are redirected to the login page when accessing settings', function () {
    $this->get('/settings/profile')->assertRedirect('/login');
});
