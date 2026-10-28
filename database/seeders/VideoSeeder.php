<?php

namespace Database\Seeders;

use App\Enums\VideoPlatform;
use App\Models\Video;
use Illuminate\Database\Seeder;

class VideoSeeder extends Seeder
{
    public function run(): void
    {
        $youtube = [
            ['Curso completo de Laravel 11 desde cero (4 horas)', 15154, 142000, now()->subWeeks(2), true, '🅻'],
            ['Construyendo un chatbot con IA en Laravel', 2301, 24000, now()->subMonth(), false, '🤖'],
            ['Livewire 3: lo que nadie te explica', 1328, 67000, now()->subMonth(), false, '⚡'],
            ['Mi setup de profesor + streamer en 2026', 942, 18000, now()->subMonths(2), false, '🎥'],
            ['PHP no está muerto (y aquí lo demuestro)', 1695, 89000, now()->subMonths(3), false, '🐘'],
        ];

        foreach ($youtube as $sort => [$title, $duration, $views, $publishedAt, $isFeatured, $icon]) {
            Video::query()->updateOrCreate(
                ['platform' => VideoPlatform::YouTube, 'title' => $title],
                [
                    'url' => 'https://youtube.com/@acenagadev',
                    'duration_seconds' => $duration,
                    'views' => $views,
                    'published_at' => $publishedAt,
                    'is_featured' => $isFeatured,
                    'icon' => $icon,
                    'sort' => $sort,
                ],
            );
        }

        $twitch = [
            ['Construyendo un SaaS con Laravel + Livewire EN VIVO', 'Software & Game Development', null, null, null, true, true, '🔴'],
            ['Refactor brutal: limpiando código de hace 5 años', 'Software Development', 13338, 8400, now()->subDays(2), false, false, '🧹'],
            ['Aprendiendo Vue 3 con la comunidad', 'Software Development', 8285, 5700, now()->subDays(5), false, false, '△'],
            ['Code Review en vivo de proyectos de la comunidad', 'Just Chatting', 14732, 12100, now()->subWeek(), false, false, '👀'],
        ];

        foreach ($twitch as $sort => [$title, $category, $duration, $views, $publishedAt, $isLive, $isFeatured, $icon]) {
            Video::query()->updateOrCreate(
                ['platform' => VideoPlatform::Twitch, 'title' => $title],
                [
                    'url' => 'https://twitch.tv/acenagadev',
                    'category' => $category,
                    'duration_seconds' => $duration,
                    'views' => $views,
                    'is_live' => $isLive,
                    'is_featured' => $isFeatured,
                    'icon' => $icon,
                    'published_at' => $publishedAt,
                    'sort' => $sort,
                ],
            );
        }
    }
}
