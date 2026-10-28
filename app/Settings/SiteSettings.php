<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class SiteSettings extends Settings
{
    public string $seo_title;

    public string $seo_description;

    public string $hero_availability;

    public string $about_title;

    public string $about_p1;

    public string $about_p2;

    public string $about_p3;

    public string $footer_made;

    /** @var array<int, string> */
    public array $taglines;

    public static function group(): string
    {
        return 'site';
    }
}
