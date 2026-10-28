<?php

namespace Database\Seeders;

use App\Models\StackGroup;
use Illuminate\Database\Seeder;

class StackSeeder extends Seeder
{
    public function run(): void
    {
        $groups = [
            ['label' => 'Lo uso todos los días', 'tools' => [
                ['PHP', '🐘'],
                ['Laravel', '🅻'],
                ['Livewire', '⚡'],
                ['Vue.js', '△'],
                ['JavaScript', '{ }'],
                ['HTML', '< >'],
                ['CSS', '#'],
                ['Tailwind', '~'],
            ]],
            ['label' => 'Cuando el proyecto lo pide', 'tools' => [
                ['WordPress', 'W'],
                ['Bootstrap', 'B'],
                ['Alpine.js', '⛰'],
            ]],
            ['label' => 'Detrás de todo', 'tools' => [
                ['Git', '⎇'],
                ['MySQL', '◆'],
                ['Vite', '▲'],
                ['Figma', '◐'],
                ['OpenAI API', '✦'],
            ]],
        ];

        foreach ($groups as $sort => ['label' => $label, 'tools' => $tools]) {
            $group = StackGroup::query()->updateOrCreate(['label' => $label], ['sort' => $sort]);

            foreach ($tools as $toolSort => [$name, $icon]) {
                $group->tools()->updateOrCreate(['name' => $name], [
                    'icon' => $icon,
                    'sort' => $toolSort,
                ]);
            }
        }
    }
}
