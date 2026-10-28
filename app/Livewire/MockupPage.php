<?php

namespace App\Livewire;

use App\Models\Site;
use App\Services\PortfolioContent;
use App\Settings\SiteSettings;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class MockupPage extends Component
{
    /** @var array<int, string> */
    public array $taglines = [];

    /** @var array<int, array{cat: string, date: string, readTime: string, title: string, excerpt: string}> */
    public array $posts = [];

    /** @var array<int, array{type: string, color: string, accent: string, emoji: string, likes: string, cmts: string}> */
    public array $instagramPosts = [];

    public array $copy = [];

    private PortfolioContent $content;

    public function mount(): void
    {
        $this->content = app(PortfolioContent::class);

        $settings = app(SiteSettings::class);

        $this->copy = [
            'navAbout' => 'Sobre mí',
            'navStack' => 'Stack',
            'navClasses' => 'Materias',
            'navProjects' => 'Proyectos',
            'navBlog' => 'Blog',
            'navInstagram' => 'Instagram',
            'navYoutube' => 'YouTube',
            'navTwitch' => 'Twitch',
            'navVideos' => 'Videos',
            'navContact' => 'Contacto',
            'heroEyebrow' => '// Carlos Ferrer · @acenagadev',
            'heroLocation' => 'Buenos Aires, Argentina',
            'heroAvailability' => $settings->hero_availability,
            'heroCtaPrimary' => 'Sígueme en YouTube',
            'heroCtaSecondary' => 'Ver mis materias',
            'aboutEyebrow' => 'Sobre mí',
            'aboutTitle' => $settings->about_title,
            'aboutP1' => $settings->about_p1,
            'aboutP2' => $settings->about_p2,
            'aboutP3' => $settings->about_p3,
            'stackEyebrow' => 'Stack técnico',
            'stackTitle' => 'Las herramientas con las que <em>realmente</em> trabajo',
            'stackSubtitle' => 'No es una lista de buzzwords, es lo que uso a diario.',
            'classesEyebrow' => 'Docencia · Escuela DaVinci',
            'classesTitle' => 'Las <em>materias</em> que enseño',
            'classesSubtitle' => 'Seis materias, un mismo objetivo: que salgas pudiendo construir cosas reales.',
            'projectsEyebrow' => 'Proyectos seleccionados',
            'projectsTitle' => 'Cosas que <em>construí</em> y todavía duermen tranquilas',
            'projectsSubtitle' => 'Una selección de trabajos en producción.',
            'blogEyebrow' => 'Entradas',
            'blogTitle' => 'Cosas que <em>escribo</em> cuando no estoy frente a una clase',
            'blogSubtitle' => 'Notas, tutoriales y reflexiones sobre desarrollo, IA y enseñanza.',
            'blogReadMore' => 'Leer más',
            'igEyebrow' => '@acenaga.dev',
            'igTitle' => 'Últimos posts en <em>Instagram</em>',
            'igSubtitle' => 'Reels, carruseles educativos y momentos detrás de cámara.',
            'igFollow' => 'Seguir en Instagram',
            'ytEyebrow' => '@acenagadev',
            'ytTitle' => 'Últimos videos en <em>YouTube</em>',
            'ytSubtitle' => 'Tutoriales, cursos y streams sobre Laravel, IA y desarrollo web.',
            'ytSubscribe' => 'Suscribirse',
            'twEyebrow' => 'twitch.tv/acenagadev',
            'twTitle' => 'Últimos streams en <em>Twitch</em>',
            'twSubtitle' => 'Coding en vivo, debugging en público y charla sobre código, IA y café.',
            'twFollow' => 'Seguir en Twitch',
            'twLive' => 'EN VIVO',
            'twVod' => 'VOD',
            'socialEyebrow' => 'Conectemos',
            'socialTitle' => 'Donde <em>vivo</em> el resto del tiempo',
            'socialSubtitle' => 'Si te gustó algo, me encontrás acá.',
            'footerMade' => $settings->footer_made,
            'footerCopy' => '© 2026 Carlos Ferrer · acenagadev',
            'footerVisitor' => 'Visitante',
        ];

        $this->posts = [
            [
                'cat' => 'Laravel',
                'date' => '15 ABR 2026',
                'readTime' => '6 min',
                'title' => 'Por qué Livewire cambió cómo enseño full-stack',
                'excerpt' => 'Un repaso honesto de cómo dejé de explicar APIs REST en clase y empecé con componentes server-side. Pros, contras y código.',
            ],
            [
                'cat' => 'Carrera',
                'date' => '02 ABR 2026',
                'readTime' => '4 min',
                'title' => 'El síndrome del impostor del programador',
                'excerpt' => 'Diez años haciendo esto y todavía dudo de mí mismo. Cómo aprendí a convivir y por qué no es solo cosa de juniors.',
            ],
            [
                'cat' => 'IA',
                'date' => '20 MAR 2026',
                'readTime' => '8 min',
                'title' => 'Construí mi propio Copilot con Laravel y OpenAI',
                'excerpt' => 'Tutorial paso a paso de cómo armar un asistente de código integrado en tu app, con streaming de respuestas y rate limiting.',
            ],
            [
                'cat' => 'Docencia',
                'date' => '10 MAR 2026',
                'readTime' => '5 min',
                'title' => 'Lo que aprendí enseñando a 500 alumnos',
                'excerpt' => 'Patrones que se repiten, las preguntas que más cuestan, y por qué a veces dejar fallar al alumno es la mejor lección.',
            ],
            [
                'cat' => 'Vue',
                'date' => '28 FEB 2026',
                'readTime' => '7 min',
                'title' => 'Vue 3 + Composition API: cuándo usarla',
                'excerpt' => 'No todo proyecto necesita la Composition API. Una guía pragmática basada en proyectos reales en producción.',
            ],
            [
                'cat' => 'Off-topic',
                'date' => '14 FEB 2026',
                'readTime' => '3 min',
                'title' => 'Mi setup de developer + creador de contenido',
                'excerpt' => 'Cámaras, micros, software, atajos de teclado y por qué uso una iluminación que parece exagerada.',
            ],
        ];

        $this->instagramPosts = [
            ['type' => 'reel', 'color' => '#110090', 'accent' => '#ffc932', 'emoji' => '🎬', 'likes' => '12.4K', 'cmts' => '342'],
            ['type' => 'carousel', 'color' => '#ffc932', 'accent' => '#110090', 'emoji' => '🎯', 'likes' => '8.7K', 'cmts' => '156'],
            ['type' => 'post', 'color' => '#4c2e84', 'accent' => '#fbdc6d', 'emoji' => '💡', 'likes' => '5.2K', 'cmts' => '87'],
            ['type' => 'reel', 'color' => '#fbdc6d', 'accent' => '#110090', 'emoji' => '⚡', 'likes' => '21.8K', 'cmts' => '512'],
            ['type' => 'carousel', 'color' => '#5f3a92', 'accent' => '#ffc932', 'emoji' => '📚', 'likes' => '6.4K', 'cmts' => '203'],
            ['type' => 'post', 'color' => '#110090', 'accent' => '#fbdc6d', 'emoji' => '🚀', 'likes' => '9.1K', 'cmts' => '178'],
            ['type' => 'reel', 'color' => '#f6c745', 'accent' => '#110090', 'emoji' => '🔥', 'likes' => '15.3K', 'cmts' => '421'],
            ['type' => 'carousel', 'color' => '#4c2e84', 'accent' => '#ffc932', 'emoji' => '🧠', 'likes' => '7.8K', 'cmts' => '231'],
            ['type' => 'post', 'color' => '#ffc932', 'accent' => '#110090', 'emoji' => '😅', 'likes' => '11.2K', 'cmts' => '298'],
            ['type' => 'reel', 'color' => '#110090', 'accent' => '#fbdc6d', 'emoji' => '☕', 'likes' => '4.9K', 'cmts' => '102'],
            ['type' => 'carousel', 'color' => '#5f3a92', 'accent' => '#fbdc6d', 'emoji' => '✨', 'likes' => '8.3K', 'cmts' => '267'],
            ['type' => 'post', 'color' => '#fbdc6d', 'accent' => '#110090', 'emoji' => '💻', 'likes' => '6.7K', 'cmts' => '145'],
        ];

        $this->taglines = $settings->taglines;
    }

    public function render(): View
    {
        $site = Site::query()->first();

        return view('livewire.mockup-page', [
            'heroImage' => $site?->getFirstMediaUrl('hero') ?: asset('mockup/og-cover.jpg'),
            'aboutImage' => $site?->getFirstMediaUrl('about') ?: null,
            'stats' => $this->content->stats(),
            'stackGroups' => $this->content->stackGroups(),
            'courses' => $this->content->courses(),
            'projects' => $this->content->projects(),
            'youtubeVideos' => $this->content->youtubeVideos(),
            'twitchVideos' => $this->content->twitchVideos(),
            'socials' => $this->content->socials(),
        ]);
    }
}
