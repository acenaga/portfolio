<?php

use App\Models\InstagramPost;
use Illuminate\Support\Facades\Http;

test('instagram sync mirrors graph api posts', function () {
    Http::fake([
        'graph.facebook.com/*' => Http::response([
            'data' => [
                [
                    'id' => 'ig_1',
                    'media_type' => 'VIDEO',
                    'caption' => 'El reelazo',
                    'media_url' => 'https://video.mp4',
                    'thumbnail_url' => 'https://video-thumb.jpg',
                    'permalink' => 'https://instagram.com/reel/ig_1',
                    'timestamp' => '2026-04-15T10:00:00-03:00',
                    'like_count' => 12400,
                    'comments_count' => 342,
                ],
                [
                    'id' => 'ig_2',
                    'media_type' => 'CAROUSEL_ALBUM',
                    'permalink' => 'https://instagram.com/p/ig_2',
                    'timestamp' => '2026-04-10T10:00:00-03:00',
                ],
            ],
        ]),
    ]);
    config()->set('portfolio.instagram.user_id', '17841400000000000');
    config()->set('portfolio.instagram.access_token', 'tok');

    $this->artisan('instagram:sync')->assertSuccessful();

    $reel = InstagramPost::query()->where('external_id', 'ig_1')->firstOrFail();
    $carousel = InstagramPost::query()->where('external_id', 'ig_2')->firstOrFail();

    expect($reel->isVideo())->toBeTrue()
        ->and($reel->like_count)->toBe(12400)
        ->and($reel->thumbnail_url)->toBe('https://video-thumb.jpg')
        ->and($carousel->isCarousel())->toBeTrue()
        ->and($carousel->media_url)->toBeNull()
        ->and(InstagramPost::count())->toBe(2);
});

test('instagram sync does nothing without credentials', function () {
    $this->artisan('instagram:sync')->assertSuccessful();

    expect(InstagramPost::count())->toBe(0);
});

test('home page renders instagram posts from the mirror', function () {
    InstagramPost::query()->create([
        'external_id' => 'ig_home',
        'media_type' => 'IMAGE',
        'media_url' => 'https://media.jpg',
        'permalink' => 'https://instagram.com/p/ig_home',
        'like_count' => 2100,
        'comments_count' => 45,
        'published_at' => now()->subDays(2),
    ]);

    $response = $this->get(route('home'));

    $response->assertOk();
    $response->assertSee('https://instagram.com/p/ig_home', false);
    $response->assertSee('https://media.jpg', false);
    $response->assertSee('2K', false);
});
