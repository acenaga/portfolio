<?php

namespace App\Console\Commands;

use App\Integrations\YouTubeApi;
use App\Models\Video;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;

class SyncYouTubeVideosCommand extends Command
{
    protected $signature = 'videos:sync-youtube';

    protected $description = 'Sincroniza los videos del canal de YouTube al espejo local';

    public function handle(YouTubeApi $youTubeApi): int
    {
        if (empty(config('portfolio.youtube.api_key'))) {
            $this->warn('YOUTUBE_API_KEY no está configurada. No se sincroniza nada.');

            return self::SUCCESS;
        }

        $synced = 0;

        foreach ($youTubeApi->latestVideos() as $data) {
            Video::query()->updateOrCreate(
                Arr::only($data, ['platform', 'external_id']),
                Arr::except($data, ['platform', 'external_id']),
            );

            $synced++;
        }

        $this->info("Videos de YouTube sincronizados: {$synced}");

        return self::SUCCESS;
    }
}
