<?php

namespace Database\Seeders;

use App\Models\Site;
use Illuminate\Database\Seeder;

class SiteSeeder extends Seeder
{
    public function run(): void
    {
        $site = Site::query()->firstOrCreate(['name' => 'acenaga.dev']);

        if (! $site->getFirstMedia('hero')) {
            $site->addMedia(resource_path('images/mockup/carlos.jpg'))
                ->preservingOriginal()
                ->toMediaCollection('hero');
        }

        if (! $site->getFirstMedia('og')) {
            $site->addMedia(resource_path('images/mockup/carlos.jpg'))
                ->preservingOriginal()
                ->toMediaCollection('og');
        }
    }
}
