<?php

namespace Database\Factories;

use App\Enums\CourseLevel;
use App\Models\Course;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Course>
 */
class CourseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->unique()->words(3, true),
            'tag' => 'HTML · CSS',
            'level' => fake()->randomElement(CourseLevel::cases()),
            'hours' => fake()->randomElement([64, 96]),
            'description' => fake()->sentence(),
            'sort' => 0,
            'is_published' => true,
        ];
    }
}
