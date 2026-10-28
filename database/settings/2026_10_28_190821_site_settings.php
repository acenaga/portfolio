<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('site.seo_title', 'Carlos Ferrer · acenagadev — Profesor, dev y creador');
        $this->migrator->add('site.seo_description', 'Profesor en DaVinci, desarrollador web full-stack con 10+ años de experiencia y creador de contenido sobre Laravel, Vue y desarrollo web.');
        $this->migrator->add('site.hero_availability', 'Disponible para clases particulares y charlas.');
        $this->migrator->add('site.about_title', '<em>Más de 10 años</em> escribiendo código y enseñando a escribirlo mejor.');
        $this->migrator->add('site.about_p1', 'Programo desde hace más de una década y todavía me emociona cuando algo compila al primer intento. Desconfío cuando pasa.');
        $this->migrator->add('site.about_p2', 'Soy profesor en DaVinci. Mi trabajo es bajar la teoría a tierra: que el cliente entienda qué se va a construir y el alumno vea que esto no es magia.');
        $this->migrator->add('site.about_p3', 'En el canal muestro el trabajo real: los errores, el debugging a las 3 a.m. y lo que sale bien.');
        $this->migrator->add('site.footer_made', 'Hecho en Buenos Aires con Laravel y Livewire');
        $this->migrator->add('site.taglines', [
            'Profesor en DaVinci y dev full-stack',
            'Hago videos y streams sobre lo que construyo',
            'Enseño Laravel y a no asustarse del error 500',
            'Devuelvo el corazón a los semicolons',
            'PHP, Vue y mucha paciencia',
            'Bug-driven development desde 2014',
        ]);
    }
};
