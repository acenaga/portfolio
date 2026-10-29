<?php

namespace App\Integrations;

use App\Enums\VideoPlatform;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

/**
 * Cliente de Twitch Helix: login de canal → VODs recientes.
 */
final class TwitchApi
{
    /** @return Collection<int, array<string, mixed>> */
    public function latestVideos(int $max = 20): Collection
    {
        $clientId = (string) config('portfolio.twitch.client_id');
        $clientSecret = (string) config('portfolio.twitch.client_secret');
        $login = (string) config('portfolio.twitch.login');

        $token = Http::asForm()->post('https://id.twitch.tv/oauth2/token', [
            'client_id' => $clientId,
            'client_secret' => $clientSecret,
            'grant_type' => 'client_credentials',
        ])->json('access_token');

        if (empty($token)) {
            return collect();
        }

        $client = Http::baseUrl('https://api.twitch.tv/helix')
            ->withHeaders([
                'Client-Id' => $clientId,
            ])
            ->withToken($token)
            ->throw();

        $userId = $client->get('users', ['login' => $login])->json('data.0.id');

        if (empty($userId)) {
            return collect();
        }

        return collect($client->get('videos', [
            'user_id' => $userId,
            'first' => $max,
        ])->json('data') ?? [])
            ->map(fn (array $item): array => [
                'external_id' => $item['id'] ?? null,
                'title' => $item['title'] ?? '',
                'url' => $item['url'] ?? null,
                'thumbnail_url' => $item['thumbnail_url'] ?? null,
                'views' => $item['view_count'] ?? 0,
                'duration_seconds' => YouTubeApi::parseIso8601Duration($item['duration'] ?? 'PT0S'),
                'published_at' => $item['created_at'] ?? null,
                'platform' => VideoPlatform::Twitch,
            ])
            ->filter(fn (array $video): bool => ! empty($video['external_id']));
    }
}
