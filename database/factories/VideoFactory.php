<?php

namespace Database\Factories;

use App\Enums\VideoPlatform;
use App\Models\Video;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Video>
 */
class VideoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'platform' => VideoPlatform::YouTube,
            'external_id' => fake()->unique()->regexify('[A-Za-z0-9_-]{11}'),
            'title' => fake()->sentence(4),
            'url' => 'https://youtube.com/watch?v=abc123',
            'thumbnail_url' => null,
            'duration_seconds' => fake()->numberBetween(600, 14400),
            'views' => fake()->numberBetween(1000, 150000),
            'is_live' => false,
            'category' => null,
            'published_at' => fake()->dateTimeBetween('-3 months', '-1 week'),
            'sort' => 0,
            'is_published' => true,
        ];
    }

    /**
     * Indicate the video belongs to a Twitch stream.
     */
    public function twitch(): static
    {
        return $this->state(fn (array $attributes) => [
            'platform' => VideoPlatform::Twitch,
            'url' => 'https://twitch.tv/videos/123456',
            'category' => 'Software Development',
        ]);
    }

    /**
     * Indicate the video is currently live.
     */
    public function live(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_live' => true,
            'duration_seconds' => null,
        ]);
    }
}
