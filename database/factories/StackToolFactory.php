<?php

namespace Database\Factories;

use App\Models\StackGroup;
use App\Models\StackTool;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<StackTool>
 */
class StackToolFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'stack_group_id' => StackGroup::factory(),
            'name' => fake()->unique()->words(2, true),
            'icon' => '⚡',
            'sort' => 0,
        ];
    }
}
