<?php

namespace App\Integrations;

use App\Enums\VideoPlatform;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

/**
 * Cliente de YouTube Data API v3: canal → playlist de uploads → videos.
 */
final class YouTubeApi
{
    /** @return Collection<int, array<string, mixed>> */
    public function latestVideos(int $max = 25): Collection
    {
        $key = (string) config('portfolio.youtube.api_key');
        $handle = (string) config('portfolio.youtube.channel_handle');

        $client = Http::baseUrl('https://www.googleapis.com/youtube/v3')->throw();

        $uploadsPlaylistId = $client->get('channels', [
            'part' => 'contentDetails',
            'forHandle' => $handle,
            'key' => $key,
        ])->json('items.0.contentDetails.relatedPlaylists.uploads');

        if (empty($uploadsPlaylistId)) {
            return collect();
        }

        return collect($client->get('playlistItems', [
            'part' => 'snippet',
            'playlistId' => $uploadsPlaylistId,
            'maxResults' => $max,
            'key' => $key,
        ])->json('items') ?? [])
            ->map(fn (array $item): array => [
                'external_id' => $item['snippet']['resourceId']['videoId'] ?? null,
                'title' => $item['snippet']['title'] ?? '',
                'published_at' => $item['snippet']['publishedAt'] ?? null,
                'thumbnail_url' => $item['snippet']['thumbnails']['maxres']['url']
                    ?? $item['snippet']['thumbnails']['high']['url']
                    ?? null,
            ])
            ->filter(fn (array $video): bool => ! empty($video['external_id']))
            ->map(function (array $video) use ($client, $key): array {
                $details = $client->get('videos', [
                    'part' => 'statistics,contentDetails',
                    'id' => $video['external_id'],
                    'key' => $key,
                ])->json('items.0');

                $video['views'] = (int) ($details['statistics']['viewCount'] ?? 0);
                $video['duration_seconds'] = self::parseIso8601Duration($details['contentDetails']['duration'] ?? 'PT0S');
                $video['url'] = 'https://youtube.com/watch?v='.$video['external_id'];
                $video['platform'] = VideoPlatform::YouTube;

                return $video;
            });
    }

    /** Convierte PT4H12M34S a segundos. */
    public static function parseIso8601Duration(string $duration): int
    {
        preg_match('/PT(?:(\d+)H)?(?:(\d+)M)?(?:(\d+)S)?/', $duration, $matches);

        return ($matches[1] ?? 0) * 3600 + ($matches[2] ?? 0) * 60 + ($matches[3] ?? 0);
    }
}
