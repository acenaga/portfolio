<?php

namespace Database\Factories;

use App\Models\SocialLink;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<SocialLink>
 */
class SocialLinkFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->unique()->randomElement(['YouTube', 'Instagram', 'Twitch', 'Kick', 'X / Twitter', 'Threads']);

        return [
            'name' => $name,
            'handle' => '@acenagadev',
            'url' => 'https://example.com/acenagadev',
            'icon' => strtolower(str_replace([' / ', ' '], ['', '-'], $name)),
            'sort' => 0,
            'is_published' => true,
        ];
    }
}
