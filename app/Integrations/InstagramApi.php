<?php

namespace App\Integrations;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

/**
 * Cliente de Instagram Graph API:últimos posts de la cuenta profesional.
 *
 * Requiere INSTAGRAM_USER_ID + INSTAGRAM_ACCESS_TOKEN (de larga vida) en el env.
 */
final class InstagramApi
{
    private const GRAPH_VERSION = 'v21.0';

    /** @return Collection<int, array<string, mixed>> */
    public function posts(int $limit = 12): Collection
    {
        $userId = (string) config('portfolio.instagram.user_id');
        $token = (string) config('portfolio.instagram.access_token');

        if ($userId === '' || $token === '') {
            return collect();
        }

        $response = Http::baseUrl('https://graph.facebook.com')
            ->throw()
            ->get(self::GRAPH_VERSION.'/'.$userId.'/media', [
                'fields' => 'id,caption,media_type,media_url,thumbnail_url,permalink,timestamp,like_count,comments_count',
                'limit' => $limit,
                'access_token' => $token,
            ])
            ->json('data') ?? [];

        return collect($response)
            ->filter(fn (array $item): bool => ! empty($item['id']))
            ->map(fn (array $item): array => [
                'external_id' => $item['id'],
                'media_type' => $item['media_type'] ?? 'IMAGE',
                'caption' => $item['caption'] ?? null,
                'media_url' => $item['media_url'] ?? null,
                'thumbnail_url' => $item['thumbnail_url'] ?? null,
                'permalink' => $item['permalink'] ?? '',
                'like_count' => $item['like_count'] ?? null,
                'comments_count' => $item['comments_count'] ?? null,
                'published_at' => $item['timestamp'] ?? null,
            ]);
    }

    /**
     * Renueva el token de larga vida (los actuales caducan a los ~60 días).
     * Devuelve el nuevo token para actualizar el env del servidor.
     */
    public function refreshedToken(): ?string
    {
        $token = (string) config('portfolio.instagram.access_token');

        if ($token === '') {
            return null;
        }

        return Http::asJson()->throw()
            ->get(self::GRAPH_VERSION.'/refresh_access_token', [
                'grant_type' => 'ig_refresh_token',
                'access_token' => $token,
            ])
            ->json('access_token');
    }
}
