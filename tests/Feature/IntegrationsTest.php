<?php

use App\Enums\VideoPlatform;
use App\Models\Post;
use App\Models\Video;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;

test('posts sync mirrors the blog api into the local table', function () {
    Http::fake([
        'fake.blog/api/posts' => Http::response([
            'data' => [
                [
                    'slug' => 'post-uno',
                    'title' => 'Post uno',
                    'excerpt' => 'Resumen del post uno',
                    'url' => 'https://fake.blog/blog/post-uno',
                    'published_at' => '2026-04-15T10:00:00-03:00',
                    'tags' => ['Laravel'],
                ],
            ],
            'meta' => ['next_page_url' => 'https://fake.blog/api/posts?page=2'],
        ]),
        'fake.blog/api/posts?page=2' => Http::response([
            'data' => [
                [
                    'slug' => 'post-dos',
                    'title' => 'Post dos',
                    'url' => 'https://fake.blog/blog/post-dos',
                    'published_at' => '2026-03-10T10:00:00-03:00',
                ],
            ],
            'meta' => ['next_page_url' => null],
        ]),
    ]);
    config()->set('portfolio.blog.base_url', 'https://fake.blog');
    config()->set('portfolio.blog.token', 'secreto');

    $this->artisan('posts:sync')->assertSuccessful();

    expect(Post::count())->toBe(2)
        ->and(Post::where('slug', 'post-uno')->firstOrFail()->excerpt)->toBe('Resumen del post uno')
        ->and(Post::where('slug', 'post-dos')->firstOrFail()->tags)->toBeNull();

    Http::assertSent(fn (Request $request): bool => $request->header('Authorization') === ['Bearer secreto']);

    $this->artisan('posts:sync')->assertSuccessful();

    expect(Post::count())->toBe(2);
});

test('youtube sync upserts videos with real numeric data', function () {
    Http::fake([
        'https://www.googleapis.com/youtube/v3/channels*' => Http::response([
            'items' => [['contentDetails' => ['relatedPlaylists' => ['uploads' => 'UU123']]]],
        ]),
        'https://www.googleapis.com/youtube/v3/playlistItems*' => Http::response([
            'items' => [
                ['snippet' => [
                    'title' => 'Mi video real',
                    'resourceId' => ['videoId' => 'abc123xyz99'],
                    'publishedAt' => '2026-04-01T10:00:00Z',
                    'thumbnails' => ['high' => ['url' => 'https://img.youtube.com/hq.jpg']],
                ]],
            ],
        ]),
        'https://www.googleapis.com/youtube/v3/videos*' => Http::response([
            'items' => [[
                'statistics' => ['viewCount' => '5000'],
                'contentDetails' => ['duration' => 'PT4H12M34S'],
            ]],
        ]),
    ]);
    config()->set('portfolio.youtube.api_key', 'key-123');
    config()->set('portfolio.youtube.channel_handle', 'acenagadev');

    $this->artisan('videos:sync-youtube')->assertSuccessful();

    $video = Video::query()->where('platform', VideoPlatform::YouTube)->firstOrFail();

    expect($video->external_id)->toBe('abc123xyz99')
        ->and($video->title)->toBe('Mi video real')
        ->and($video->views)->toBe(5000)
        ->and($video->duration_seconds)->toBe(15154)
        ->and($video->thumbnail_url)->toBe('https://img.youtube.com/hq.jpg')
        ->and($video->url)->toBe('https://youtube.com/watch?v=abc123xyz99');
});

test('twitch sync upserts vods with the helix data', function () {
    Http::fake([
        'https://id.twitch.tv/oauth2/token' => Http::response(['access_token' => 'tok']),
        'https://api.twitch.tv/helix/users*' => Http::response(['data' => [['id' => '999']]]),
        'https://api.twitch.tv/helix/videos*' => Http::response([
            'data' => [
                [
                    'id' => '555',
                    'title' => 'VOD refactor',
                    'url' => 'https://twitch.tv/videos/555',
                    'duration' => 'PT3H42M18S',
                    'view_count' => 8400,
                    'created_at' => '2026-04-20T20:00:00Z',
                    'thumbnail_url' => 'https://twitch.tv/thumb.jpg',
                ],
            ],
        ]),
    ]);
    config()->set('portfolio.twitch.client_id', 'cid');
    config()->set('portfolio.twitch.client_secret', 'secret');

    $this->artisan('videos:sync-twitch')->assertSuccessful();

    $video = Video::query()->where('platform', VideoPlatform::Twitch)->firstOrFail();

    expect($video->external_id)->toBe('555')
        ->and($video->views)->toBe(8400)
        ->and($video->duration_seconds)->toBe(13338)
        ->and($video->url)->toBe('https://twitch.tv/videos/555');
});

test('sync commands do nothing without credentials', function () {
    $this->artisan('posts:sync')->assertSuccessful();
    $this->artisan('videos:sync-youtube')->assertSuccessful();
    $this->artisan('videos:sync-twitch')->assertSuccessful();

    expect(Post::count())->toBe(0)
        ->and(Video::count())->toBe(0);
});

test('home page renders posts from the mirror', function () {
    Post::query()->create([
        'slug' => 'post-home',
        'title' => 'Post renderizado en el home',
        'url' => 'https://fake.blog/blog/post-home',
        'tags' => ['Laravel', 'Vue'],
        'published_at' => now()->subDays(3),
    ]);

    $response = $this->get(route('home'));

    $response->assertOk();
    $response->assertSee('Post renderizado en el home', false);
    $response->assertSee('Laravel', false);
});
