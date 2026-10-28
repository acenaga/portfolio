<?php

namespace App\Services;

use App\Models\Course;
use App\Models\Project;
use App\Models\SiteStat;
use App\Models\SocialLink;
use App\Models\StackGroup;
use App\Models\Video;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

final class PortfolioContent
{
    private const PREFIX = 'portfolio.';

    /**
     * All cached portfolio collections, keyed by cache key.
     */
    public static function flush(): void
    {
        Cache::delete(self::PREFIX.'stats');
        Cache::delete(self::PREFIX.'stack_groups');
        Cache::delete(self::PREFIX.'courses');
        Cache::delete(self::PREFIX.'projects');
        Cache::delete(self::PREFIX.'youtube_videos');
        Cache::delete(self::PREFIX.'twitch_videos');
        Cache::delete(self::PREFIX.'socials');
    }

    /** @return Collection<int, SiteStat> */
    public static function stats(): Collection
    {
        return Cache::rememberForever(self::PREFIX.'stats', fn () => SiteStat::query()->published()->get());
    }

    /** @return Collection<int, StackGroup> */
    public static function stackGroups(): Collection
    {
        return Cache::rememberForever(self::PREFIX.'stack_groups', fn () => StackGroup::query()->publishedWithTools()->get());
    }

    /** @return Collection<int, Course> */
    public static function courses(): Collection
    {
        return Cache::rememberForever(self::PREFIX.'courses', fn () => Course::query()->published()->get());
    }

    /** @return Collection<int, Project> */
    public static function projects(): Collection
    {
        return Cache::rememberForever(self::PREFIX.'projects', fn () => Project::query()->published()->get());
    }

    /** @return Collection<int, Video> */
    public static function youtubeVideos(): Collection
    {
        return Cache::rememberForever(self::PREFIX.'youtube_videos', fn () => Video::query()->where('platform', 'youtube')->published()->orderByDesc('is_featured')->get());
    }

    /** @return Collection<int, Video> */
    public static function twitchVideos(): Collection
    {
        return Cache::rememberForever(self::PREFIX.'twitch_videos', fn () => Video::query()->where('platform', 'twitch')->published()->get());
    }

    /** @return Collection<int, SocialLink> */
    public static function socials(): Collection
    {
        return Cache::rememberForever(self::PREFIX.'socials', fn () => SocialLink::query()->published()->get());
    }
}
