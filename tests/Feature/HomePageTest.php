<?php

test('users can visit the home page', function () {
    $response = $this->get(route('home'));

    $response->assertSuccessful();
    $response->assertSee('Carlos Ferrer', false);
    $response->assertSee('data-mockup-root', false);
    $response->assertDontSee('react.production.min.js', false);
});
