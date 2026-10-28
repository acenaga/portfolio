<?php

namespace Database\Factories;

use App\Models\StackGroup;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<StackGroup>
 */
class StackGroupFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'label' => fake()->unique()->words(3, true),
            'sort' => 0,
            'is_published' => true,
        ];
    }
}
