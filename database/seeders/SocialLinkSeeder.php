<?php

namespace Database\Seeders;

use App\Models\SocialLink;
use Illuminate\Database\Seeder;

class SocialLinkSeeder extends Seeder
{
    public function run(): void
    {
        $socials = [
            ['YouTube', '@acenagadev', 'https://youtube.com/@acenagadev', 'youtube'],
            ['Instagram', '@acenaga.dev', 'https://instagram.com/acenaga.dev', 'instagram'],
            ['Twitch', 'acenagadev', 'https://twitch.tv/acenagadev', 'twitch'],
            ['Kick', 'acenagadev', 'https://kick.com/acenagadev', 'kick'],
            ['X / Twitter', '@acenagadev', 'https://x.com/acenagadev', 'x'],
            ['Threads', '@acenaga.dev', 'https://threads.net/@acenaga.dev', 'threads'],
        ];

        foreach ($socials as $sort => [$name, $handle, $url, $icon]) {
            SocialLink::query()->updateOrCreate(['name' => $name], [
                'handle' => $handle,
                'url' => $url,
                'icon' => $icon,
                'sort' => $sort,
            ]);
        }
    }
}
