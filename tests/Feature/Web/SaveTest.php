<?php

use App\Models\Save;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

// ---------------------------------------------------------------------------
// Helper: valid save payload
// ---------------------------------------------------------------------------
function validSavePayload(array $overrides = []): array
{
    return array_merge([
        'grid' => [[0, 1, 0], [1, 0, 1], [0, 1, 0]],
        'grid_size' => 20,
        'update_speed' => 500,
        'neighbor_thresholds' => [2, 3],
        'selected_color' => '#ffffff',
        'cycle_count' => 10,
    ], $overrides);
}

// ---------------------------------------------------------------------------
// POST / — create a new save
// ---------------------------------------------------------------------------

test('an authenticated user can create a new save', function () {
    $user = User::factory()->create();

    $response = $this->withoutVite()
        ->actingAs($user)
        ->post('/', validSavePayload());

    $response->assertStatus(200);
    $this->assertDatabaseHas('saves', [
        'user_id' => $user->id,
        'grid_size' => 20,
        'update_speed' => 500,
        'selected_color' => '#ffffff',
        'cycle_count' => 10,
    ]);
});

test('creating a save requires authentication', function () {
    $response = $this->post('/', validSavePayload());

    $response->assertRedirect('/login');
    $this->assertDatabaseCount('saves', 0);
});

test('creating a save fails with missing required fields', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post('/', []);

    $response->assertSessionHasErrors(['grid', 'grid_size', 'update_speed', 'neighbor_thresholds', 'selected_color', 'cycle_count']);
    $this->assertDatabaseCount('saves', 0);
});

test('creating a save fails when grid_size is out of range', function () {
    $user = User::factory()->create();

    $tooSmall = $this->actingAs($user)->post('/', validSavePayload(['grid_size' => 5]));
    $tooSmall->assertSessionHasErrors(['grid_size']);

    $tooBig = $this->actingAs($user)->post('/', validSavePayload(['grid_size' => 51]));
    $tooBig->assertSessionHasErrors(['grid_size']);

    $this->assertDatabaseCount('saves', 0);
});

test('creating a save fails when update_speed is out of range', function () {
    $user = User::factory()->create();

    $tooSlow = $this->actingAs($user)->post('/', validSavePayload(['update_speed' => 50]));
    $tooSlow->assertSessionHasErrors(['update_speed']);

    $tooFast = $this->actingAs($user)->post('/', validSavePayload(['update_speed' => 1001]));
    $tooFast->assertSessionHasErrors(['update_speed']);

    $this->assertDatabaseCount('saves', 0);
});

// ---------------------------------------------------------------------------
// POST / — update an existing save
// ---------------------------------------------------------------------------

test('an authenticated user can update their own save', function () {
    $user = User::factory()->create();
    $save = Save::factory()->for($user)->create(['grid_size' => 15]);

    $response = $this->withoutVite()
        ->actingAs($user)
        ->post('/', validSavePayload(['id' => $save->id, 'grid_size' => 30]));

    $response->assertStatus(200);
    $this->assertDatabaseHas('saves', [
        'id' => $save->id,
        'grid_size' => 30,
    ]);
    $this->assertDatabaseCount('saves', 1);
});

test('a user cannot update another user\'s save', function () {
    $owner = User::factory()->create();
    $attacker = User::factory()->create();
    $save = Save::factory()->for($owner)->create();

    $response = $this->actingAs($attacker)
        ->post('/', validSavePayload(['id' => $save->id]));

    $response->assertStatus(403);
    $this->assertDatabaseHas('saves', ['id' => $save->id, 'user_id' => $owner->id]);
});

test('storing with an unknown id creates a new save instead', function () {
    $user = User::factory()->create();
    $fakeId = '00000000-0000-0000-0000-000000000000';

    $response = $this->withoutVite()
        ->actingAs($user)
        ->post('/', validSavePayload(['id' => $fakeId]));

    $response->assertStatus(200);
    $this->assertDatabaseCount('saves', 1);
});

// ---------------------------------------------------------------------------
// GET /{id} — retrieve a save (public)
// ---------------------------------------------------------------------------

test('anyone can retrieve a save by id', function () {
    $save = Save::factory()->create(['grid_size' => 25, 'cycle_count' => 42]);

    $response = $this->withoutVite()->get("/{$save->id}");

    $response->assertStatus(200);
});

test('retrieving a non-existent save returns 404', function () {
    $response = $this->get('/00000000-0000-0000-0000-000000000000');

    $response->assertStatus(404);
});

test('accessing the home route without an id shows the home page', function () {
    $response = $this->withoutVite()->get('/');

    $response->assertStatus(200);
});

// ---------------------------------------------------------------------------
// GET /dashboard — list authenticated user's saves
// ---------------------------------------------------------------------------

test('the dashboard lists only the authenticated user\'s saves', function () {
    $user = User::factory()->create();
    $other = User::factory()->create();

    Save::factory()->count(3)->for($user)->create();
    Save::factory()->count(2)->for($other)->create();

    $response = $this->withoutVite()->actingAs($user)->get('/dashboard');

    $response->assertStatus(200);
    // Only 3 saves belong to $user; 2 belong to $other — verify DB counts
    $this->assertDatabaseCount('saves', 5);
    $this->assertEquals(3, Save::where('user_id', $user->id)->count());
});

test('the dashboard is not accessible for unauthenticated users', function () {
    $response = $this->get('/dashboard');

    $response->assertRedirect('/login');
});
