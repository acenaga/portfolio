<?php

use App\Models\User;

test('guests are redirected to the admin login page', function () {
    $this->get(route('filament.admin.auth.login'))
        ->assertOk();

    $this->get('/admin')
        ->assertRedirect(route('filament.admin.auth.login'));
});

test('users without admin access are forbidden from the panel', function () {
    $user = User::factory()->create(['is_admin' => false]);

    $this->actingAs($user)
        ->get('/admin')
        ->assertForbidden();
});

test('admins can access the panel dashboard', function () {
    $admin = User::factory()->admin()->create();

    $this->actingAs($admin)
        ->get('/admin')
        ->assertOk();
});
