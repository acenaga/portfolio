<?php

use App\Models\User;

test('admin can see every content resource index', function () {
    $this->seed();

    $admin = User::factory()->admin()->create();
    $this->actingAs($admin);

    foreach (['projects', 'courses', 'videos', 'social-links', 'site-stats', 'stack-groups'] as $slug) {
        $this->get("/admin/{$slug}")->assertOk();
    }
});
