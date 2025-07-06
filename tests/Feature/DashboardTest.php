<?php

use App\Models\User;

test('guests are redirected to the login page', function () {
    $response = $this->get('/collection');
    $response->assertRedirect('/login');
});

test('authenticated users can visit the collection', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $response = $this->get('/collection');
    $response->assertStatus(200);
});