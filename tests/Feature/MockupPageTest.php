<?php

test('users can visit the mockup page', function () {
    $response = $this->get(route('mockup'));

    $response->assertSuccessful();
    $response->assertSee('Carlos Ferrer', false);
    $response->assertSee('data-mockup-root', false);
    $response->assertDontSee('react.production.min.js', false);
});
