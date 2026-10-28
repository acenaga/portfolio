<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        $projects = [
            ['Mentoría Bot', ['Laravel', 'OpenAI', 'Livewire'], '🤖', 'Asistente con IA que ayuda a alumnos a debuggear código en tiempo real. Detecta intenciones del estudiante y devuelve explicaciones, no soluciones.'],
            ['Cursos.dev', ['Laravel', 'Vue', 'MySQL'], '🎓', 'Plataforma de cursos online en español con video, transcripciones, ejercicios autocorregidos y comunidad. Más de 2.000 estudiantes activos.'],
            ['StreamHub LATAM', ['Vue', 'Tailwind', 'API'], '📡', 'Dashboard que agrega streams de Twitch, YouTube y Kick de devs hispanohablantes. Útil para descubrir contenido y ver quién está en vivo.'],
            ['CodeRoast', ['Livewire', 'Alpine', 'IA'], '🔥', 'Subes un snippet de código y la IA lo roastea con humor mientras te enseña qué se puede mejorar. Un proyecto pasión que se volvió viral.'],
        ];

        foreach ($projects as $sort => [$name, $tags, $icon, $description]) {
            Project::query()->updateOrCreate(['name' => $name], [
                'description' => $description,
                'url' => '#',
                'icon' => $icon,
                'tags' => $tags,
                'sort' => $sort,
            ]);
        }
    }
}
