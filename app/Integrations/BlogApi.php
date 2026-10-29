<?php

namespace App\Integrations;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

/**
 * Cliente del contrato GET /api/posts de la otra página.
 *
 * @see /docs del plan: slug, title, url y published_at obligatorios; excerpt, tags y cover_url opcionales.
 */
final class BlogApi
{
    /** @return Collection<int, array<string, mixed>> */
    public function posts(): Collection
    {
        $base = (string) config('portfolio.blog.base_url');
        $token = (string) config('portfolio.blog.token');

        $client = Http::asJson()
            ->when($token !== '', fn (PendingRequest $http): PendingRequest => $http->withToken($token))
            ->baseUrl($base)
            ->retry(2, 500)
            ->throw();

        $items = collect();
        $url = '/api/posts';

        while ($url !== null) {
            $response = $client->get($url)->json();

            $items = $items->concat($response['data'] ?? []);

            $url = $response['meta']['next_page_url'] ?? null;
        }

        return $items;
    }
}
