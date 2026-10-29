<?php

return [
    'blog' => [
        // Endpoint de la otra página que expone GET /api/posts (contrato en el plan).
        'base_url' => env('PORTFOLIO_BLOG_API_URL'),
        'token' => env('PORTFOLIO_BLOG_API_TOKEN'),
    ],

    'youtube' => [
        'channel_handle' => env('PORTFOLIO_YOUTUBE_HANDLE', 'acenagadev'),
        'api_key' => env('YOUTUBE_API_KEY'),
    ],

    'twitch' => [
        'client_id' => env('TWITCH_CLIENT_ID'),
        'client_secret' => env('TWITCH_CLIENT_SECRET'),
        'login' => env('PORTFOLIO_TWITCH_LOGIN', 'acenagadev'),
    ],

    'instagram' => [
        // Cuenta profesional de IG vinculada a la app de Meta.
        'user_id' => env('INSTAGRAM_USER_ID'),
        'access_token' => env('INSTAGRAM_ACCESS_TOKEN'),
    ],
];
