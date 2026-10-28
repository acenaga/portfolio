<?php

namespace Database\Factories;

use App\Models\SiteStat;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<SiteStat>
 */
class SiteStatFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'value' => (string) fake()->numberBetween(5, 500).'+',
            'label' => strtoupper(fake()->words(2, true)),
            'sort' => 0,
            'is_published' => true,
        ];
    }
}
