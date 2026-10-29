<?php

namespace App\Console\Commands;

use App\Integrations\InstagramApi;
use App\Models\InstagramPost;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;

class SyncInstagramPostsCommand extends Command
{
    protected $signature = 'instagram:sync';

    protected $description = 'Sincroniza los posts de Instagram (Graph API) al espejo local';

    public function handle(InstagramApi $instagramApi): int
    {
        if (empty(config('portfolio.instagram.user_id')) || empty(config('portfolio.instagram.access_token'))) {
            $this->warn('INSTAGRAM_USER_ID/INSTAGRAM_ACCESS_TOKEN no están configurados. No se sincroniza nada.');

            return self::SUCCESS;
        }

        $synced = 0;

        foreach ($instagramApi->posts() as $data) {
            InstagramPost::query()->updateOrCreate(
                Arr::only($data, ['external_id']),
                [
                    ...Arr::except($data, ['external_id']),
                    'fetched_at' => now(),
                ],
            );

            $synced++;
        }

        $this->info("Posts de Instagram sincronizados: {$synced}");

        return self::SUCCESS;
    }
}
