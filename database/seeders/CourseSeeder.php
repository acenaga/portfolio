<?php

namespace Database\Seeders;

use App\Enums\CourseLevel;
use App\Models\Course;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    public function run(): void
    {
        $courses = [
            ['Maquetado y Desarrollo Web', 'HTML · CSS', CourseLevel::Initial, 64, 'Los cimientos de todo. Aprendemos a estructurar contenido con HTML semántico y a darle vida con CSS moderno: flexbox, grid, animaciones y diseño responsive sin frameworks.'],
            ['Programación I', 'JavaScript', CourseLevel::Initial, 64, 'Tu primer hola mundo que en realidad responde. Variables, condicionales, funciones, DOM y eventos. Salimos pudiendo construir interactividad real en el navegador.'],
            ['Programación con Entornos', 'WordPress', CourseLevel::Intermediate, 64, 'WordPress sin miedo: temas hijos, custom post types, hooks y un poquito de plugin propio. Salís pudiendo entregar sitios profesionales y mantenibles.'],
            ['Portales y Comercio Electrónico', 'Laravel', CourseLevel::Intermediate, 96, 'Construimos un e-commerce real con Laravel: catálogos, carrito, pagos, panel admin. Buenas prácticas, MVC, Eloquent y mucho debugging compartido.'],
            ['Aplicaciones Web Progresivas', 'JavaScript', CourseLevel::Advanced, 64, 'PWAs en serio. Service workers, cache estratégica, instalación, push notifications y todo lo que hace que tu web se sienta como una app nativa.'],
            ['Producción Web', 'Laravel', CourseLevel::Advanced, 96, 'Como se hace en la vida real: deploy, testing, queues, jobs, APIs, autenticación robusta y patrones de arquitectura para apps que no se rompan en producción.'],
        ];

        foreach ($courses as $sort => [$title, $tag, $level, $hours, $description]) {
            Course::query()->updateOrCreate(['title' => $title], [
                'tag' => $tag,
                'level' => $level,
                'hours' => $hours,
                'description' => $description,
                'sort' => $sort,
            ]);
        }
    }
}
