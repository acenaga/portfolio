<?php

namespace App\Console\Commands;

use App\Integrations\TwitchApi;
use App\Models\Video;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;

class SyncTwitchVideosCommand extends Command
{
    protected $signature = 'videos:sync-twitch';

    protected $description = 'Sincroniza los VODs del canal de Twitch al espejo local';

    public function handle(TwitchApi $twitchApi): int
    {
        if (empty(config('portfolio.twitch.client_id'))) {
            $this->warn('TWITCH_CLIENT_ID no está configurado. No se sincroniza nada.');

            return self::SUCCESS;
        }

        $synced = 0;

        foreach ($twitchApi->latestVideos() as $data) {
            Video::query()->updateOrCreate(
                Arr::only($data, ['platform', 'external_id']),
                Arr::except($data, ['platform', 'external_id']),
            );

            $synced++;
        }

        $this->info("Videos de Twitch sincronizados: {$synced}");

        return self::SUCCESS;
    }
}
