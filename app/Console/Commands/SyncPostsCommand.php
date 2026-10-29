<?php

namespace App\Console\Commands;

use App\Integrations\BlogApi;
use App\Models\Post;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class SyncPostsCommand extends Command
{
    protected $signature = 'posts:sync';

    protected $description = 'Sincroniza los posts de la otra página vía su API al espejo local';

    public function handle(BlogApi $blogApi): int
    {
        if (empty(config('portfolio.blog.base_url'))) {
            $this->warn('PORTFOLIO_BLOG_API_URL no está configurado. No se sincroniza nada.');

            return self::SUCCESS;
        }

        $fetched = 0;

        foreach ($blogApi->posts() as $item) {
            Post::query()->updateOrCreate(
                ['slug' => $item['slug']],
                [
                    'title' => $item['title'],
                    'excerpt' => $item['excerpt'] ?? null,
                    'url' => $item['url'],
                    'tags' => $item['tags'] ?? null,
                    'cover_url' => $item['cover_url'] ?? null,
                    'published_at' => isset($item['published_at'])
                        ? Carbon::parse($item['published_at'])
                        : null,
                    'fetched_at' => now(),
                ],
            );

            $fetched++;
        }

        $this->info("Posts sincronizados: {$fetched}");

        return self::SUCCESS;
    }
}
