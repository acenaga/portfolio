<?php

namespace Database\Seeders;

use App\Models\SiteStat;
use Illuminate\Database\Seeder;

class SiteStatSeeder extends Seeder
{
    public function run(): void
    {
        $stats = [
            ['value' => '10+', 'label' => 'AÑOS DE EXPERIENCIA'],
            ['value' => '500+', 'label' => 'ESTUDIANTES'],
            ['value' => '50+', 'label' => 'PROYECTOS'],
            ['value' => '6', 'label' => 'MATERIAS POR AÑO'],
        ];

        foreach ($stats as $sort => ['value' => $value, 'label' => $label]) {
            SiteStat::query()->updateOrCreate(['label' => $label], [
                'value' => $value,
                'sort' => $sort,
            ]);
        }
    }
}
