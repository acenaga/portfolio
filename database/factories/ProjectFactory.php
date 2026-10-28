<?php

namespace Database\Factories;

use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Project>
 */
class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->unique()->words(2, true);

        return [
            'name' => ucwords($name),
            'description' => fake()->sentence(),
            'url' => '#',
            'icon' => '🔧',
            'tags' => fake()->randomElements(['Laravel', 'Vue', 'Livewire', 'Tailwind', 'MySQL'], 2),
            'sort' => 0,
            'is_published' => true,
        ];
    }
}
