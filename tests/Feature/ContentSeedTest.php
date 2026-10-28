<?php

use App\Enums\VideoPlatform;
use App\Models\Course;
use App\Models\Project;
use App\Models\Site;
use App\Models\SiteStat;
use App\Models\SocialLink;
use App\Models\StackGroup;
use App\Models\StackTool;
use App\Models\Video;

test('portfolio content seeders populate every entity', function () {
    $this->seed();

    expect(Project::count())->toBe(4)
        ->and(Course::count())->toBe(6)
        ->and(Video::where('platform', VideoPlatform::YouTube)->count())->toBe(5)
        ->and(Video::where('platform', VideoPlatform::Twitch)->count())->toBe(4)
        ->and(SocialLink::count())->toBe(6)
        ->and(SiteStat::count())->toBe(4)
        ->and(StackGroup::count())->toBe(3)
        ->and(StackTool::count())->toBe(16)
        ->and(Site::count())->toBe(1)
        ->and(Site::firstOrFail()->getFirstMedia('hero'))->not->toBeNull();
});

test('videos store numeric data instead of mock strings', function () {
    $this->seed();

    $video = Video::query()->where('platform', VideoPlatform::YouTube)->firstOrFail();

    expect($video->views)->toBeInt()
        ->and($video->duration_seconds)->toBeInt()
        ->and($video->published_at)->not->toBeNull()
        ->and($video->is_live)->toBeFalse();
});

test('stack tools belong to their group and keep order', function () {
    $this->seed();

    $group = StackGroup::query()->where('label', 'Cuando el proyecto lo pide')->firstOrFail();

    expect($group->tools->count())->toBe(3)
        ->and($group->tools->first()->name)->toBe('WordPress')
        ->and($group->tools->first()->group->is($group))->toBeTrue();
});
