<?php

namespace App\Livewire;

use Livewire\Component;

class MockupPage extends Component
{
    public string $carlosImage = '';

    /** @var array<int, array{num: string, label: string}> */
    public array $stats = [];

    /** @var array<int, array{name: string, icon: string}> */
    public array $stack = [];

    /** @var array<int, string> */
    public array $stackMarquee = [];

    /** @var array<int, array{title: string, tag: string, level: string, hours: string, desc: string}> */
    public array $classes = [];

    /** @var array<int, array{name: string, tags: array<int, string>, color: string, bg: string, icon: string, desc: string, url: string}> */
    public array $projects = [];

    /** @var array<int, array{cat: string, date: string, readTime: string, title: string, excerpt: string}> */
    public array $posts = [];

    /** @var array<int, array{type: string, color: string, accent: string, emoji: string, likes: string, cmts: string}> */
    public array $instagramPosts = [];

    /** @var array<int, array{featured?: bool, title: string, duration: string, views: string, ago: string, bg: string, accent: string, emoji: string}> */
    public array $youtubeVideos = [];

    /** @var array<int, array{live?: bool, title: string, category: string, viewers?: string, duration?: string, views?: string, ago: string, bg: string, accent: string, emoji: string}> */
    public array $twitchStreams = [];

    /** @var array<int, array{name: string, handle: string, url: string, icon: string}> */
    public array $socials = [];

    /** @var array<int, string> */
    public array $taglines = [];

    public array $copy = [];

    public function mount(string $carlosImage): void
    {
        $this->carlosImage = $carlosImage;

        $this->copy = [
            'navAbout' => 'Sobre mi',
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
            'heroAvailability' => 'Disponible para charlas, mentorias y caos creativo',
            'heroCtaPrimary' => 'Sigueme en YouTube',
            'heroCtaSecondary' => 'Ver mis materias',
            'heroStatusOn' => 'EN_LINEA',
            'aboutEyebrow' => 'Sobre mi',
            'aboutTitle' => '<em>10+ anos</em> haciendo que el codigo tenga sentido (y un poco de gracia).',
            'aboutP1' => 'Me apasiona el desarrollo web por la posibilidad de construir lo que otros suenan. Llevo mas de una decada en este mundo y todavia me emociono cuando algo finalmente compila.',
            'aboutP2' => 'Soy profesor en DaVinci, donde mi mision es bajar el conocimiento complejo a palabras humanas, para que clientes entiendan que se va a construir y mis alumnos sientan que esto no es magia inalcanzable.',
            'aboutP3' => 'Como creador de contenido muestro la realidad del desarrollo: los errores, las soluciones a las 3 a.m., el sindrome del impostor y tambien las victorias. Todo con humor, porque si no nos reimos, que estamos haciendo.',
            'stackEyebrow' => 'Stack tecnico',
            'stackTitle' => 'Las herramientas con las que <em>realmente</em> trabajo',
            'stackSubtitle' => 'No es una lista de buzzwords, es lo que uso a diario.',
            'classesEyebrow' => 'Docencia · Escuela DaVinci',
            'classesTitle' => 'Las <em>materias</em> que enseno',
            'classesSubtitle' => 'Seis materias, un mismo objetivo: que salgas pudiendo construir cosas reales.',
            'projectsEyebrow' => 'Proyectos seleccionados',
            'projectsTitle' => 'Cosas que <em>construi</em> y todavia duermen tranquilas',
            'projectsSubtitle' => 'Una seleccion de trabajos en produccion.',
            'blogEyebrow' => 'Entradas',
            'blogTitle' => 'Cosas que <em>escribo</em> cuando no estoy frente a una clase',
            'blogSubtitle' => 'Notas, tutoriales y reflexiones sobre desarrollo, IA y ensenanza.',
            'blogReadMore' => 'Leer mas',
            'igEyebrow' => '@acenaga.dev',
            'igTitle' => 'Ultimos posts en <em>Instagram</em>',
            'igSubtitle' => 'Reels, carruseles educativos y momentos detras de camara.',
            'igFollow' => 'Seguir en Instagram',
            'ytEyebrow' => '@acenagadev',
            'ytTitle' => 'Ultimos videos en <em>YouTube</em>',
            'ytSubtitle' => 'Tutoriales, cursos y streams sobre Laravel, IA y desarrollo web.',
            'ytSubscribe' => 'Suscribirse',
            'twEyebrow' => 'twitch.tv/acenagadev',
            'twTitle' => 'Ultimos streams en <em>Twitch</em>',
            'twSubtitle' => 'Coding en vivo, debugging en publico y charla sobre codigo, IA y cafe.',
            'twFollow' => 'Seguir en Twitch',
            'twLive' => 'EN VIVO',
            'twVod' => 'VOD',
            'socialEyebrow' => 'Conectemos',
            'socialTitle' => 'Donde <em>vivo</em> el resto del tiempo',
            'socialSubtitle' => 'Si te gusto algo, me encuentras aqui.',
            'footerMade' => 'Hecho con Laravel mental, cafe y mucho amor en Buenos Aires',
            'footerCopy' => '© 2026 Carlos Ferrer · acenagadev',
            'footerVisitor' => 'Visitante',
        ];

        $this->stats = [
            ['num' => '10+', 'label' => 'ANOS DE EXPERIENCIA'],
            ['num' => '500+', 'label' => 'ESTUDIANTES'],
            ['num' => '50+', 'label' => 'PROYECTOS'],
            ['num' => '∞', 'label' => 'CAFES'],
        ];

        $this->stack = [
            ['name' => 'Laravel', 'icon' => '🅻'],
            ['name' => 'PHP', 'icon' => '🐘'],
            ['name' => 'Vue.js', 'icon' => '△'],
            ['name' => 'Livewire', 'icon' => '⚡'],
            ['name' => 'JavaScript', 'icon' => '{ }'],
            ['name' => 'HTML', 'icon' => '< >'],
            ['name' => 'CSS', 'icon' => '#'],
            ['name' => 'Bootstrap', 'icon' => 'B'],
            ['name' => 'Alpine.js', 'icon' => '⛰'],
            ['name' => 'Tailwind', 'icon' => '~'],
            ['name' => 'WordPress', 'icon' => 'W'],
            ['name' => 'MySQL', 'icon' => '◆'],
            ['name' => 'Git', 'icon' => '⎇'],
            ['name' => 'Figma', 'icon' => '◐'],
            ['name' => 'OpenAI API', 'icon' => '✦'],
            ['name' => 'Vite', 'icon' => '⚡'],
        ];

        $this->stackMarquee = ['LARAVEL', 'PHP', 'VUE.JS', 'LIVEWIRE', 'JAVASCRIPT', 'BOOTSTRAP', 'WORDPRESS', 'TAILWIND', 'IA', 'OPENAI', 'GIT', 'MYSQL'];

        $this->classes = [
            [
                'title' => 'Maquetado y Desarrollo Web',
                'tag' => 'HTML · CSS',
                'level' => 'Inicial',
                'hours' => '64hs',
                'desc' => 'Los cimientos de todo. Aprendemos a estructurar contenido con HTML semantico y a darle vida con CSS moderno: flexbox, grid, animaciones y diseno responsive sin frameworks.',
            ],
            [
                'title' => 'Programacion I',
                'tag' => 'JavaScript',
                'level' => 'Inicial',
                'hours' => '64hs',
                'desc' => 'Tu primer hola mundo que en realidad responde. Variables, condicionales, funciones, DOM y eventos. Salimos pudiendo construir interactividad real en el navegador.',
            ],
            [
                'title' => 'Programacion con Entornos',
                'tag' => 'WordPress',
                'level' => 'Intermedio',
                'hours' => '64hs',
                'desc' => 'WordPress sin miedo: temas hijos, custom post types, hooks y un poquito de plugin propio. Salis pudiendo entregar sitios profesionales y mantenibles.',
            ],
            [
                'title' => 'Portales y Comercio Electronico',
                'tag' => 'Laravel',
                'level' => 'Intermedio',
                'hours' => '96hs',
                'desc' => 'Construimos un e-commerce real con Laravel: catalogos, carrito, pagos, panel admin. Buenas practicas, MVC, Eloquent y mucho debugging compartido.',
            ],
            [
                'title' => 'Aplicaciones Web Progresivas',
                'tag' => 'JavaScript',
                'level' => 'Avanzado',
                'hours' => '64hs',
                'desc' => 'PWAs en serio. Service workers, cache estrategica, instalacion, push notifications y todo lo que hace que tu web se sienta como una app nativa.',
            ],
            [
                'title' => 'Produccion Web',
                'tag' => 'Laravel',
                'level' => 'Avanzado',
                'hours' => '96hs',
                'desc' => 'Como se hace en la vida real: deploy, testing, queues, jobs, APIs, autenticacion robusta y patrones de arquitectura para apps que no se rompan en produccion.',
            ],
        ];

        $this->projects = [
            [
                'name' => 'Mentoria Bot',
                'tags' => ['Laravel', 'OpenAI', 'Livewire'],
                'color' => '#ffc932',
                'bg' => '#110090',
                'icon' => '🤖',
                'desc' => 'Asistente con IA que ayuda a alumnos a debuggear codigo en tiempo real. Detecta intenciones del estudiante y devuelve explicaciones, no soluciones.',
                'url' => '#',
            ],
            [
                'name' => 'Cursos.dev',
                'tags' => ['Laravel', 'Vue', 'MySQL'],
                'color' => '#110090',
                'bg' => '#fbdc6d',
                'icon' => '🎓',
                'desc' => 'Plataforma de cursos online en espanol con video, transcripciones, ejercicios autocorregidos y comunidad. Mas de 2.000 estudiantes activos.',
                'url' => '#',
            ],
            [
                'name' => 'StreamHub LATAM',
                'tags' => ['Vue', 'Tailwind', 'API'],
                'color' => '#fbdc6d',
                'bg' => '#4c2e84',
                'icon' => '📡',
                'desc' => 'Dashboard que agrega streams de Twitch, YouTube y Kick de devs hispanohablantes. Util para descubrir contenido y ver quien esta en vivo.',
                'url' => '#',
            ],
            [
                'name' => 'CodeRoast',
                'tags' => ['Livewire', 'Alpine', 'IA'],
                'color' => '#5f3a92',
                'bg' => '#ffc932',
                'icon' => '🔥',
                'desc' => 'Subes un snippet de codigo y la IA lo roastea con humor mientras te ensena que se puede mejorar. Un proyecto pasion que se volvio viral.',
                'url' => '#',
            ],
        ];

        $this->posts = [
            [
                'cat' => 'Laravel',
                'date' => '15 ABR 2026',
                'readTime' => '6 min',
                'title' => 'Por que Livewire cambio como enseno full-stack',
                'excerpt' => 'Un repaso honesto de como deje de explicar APIs REST en clase y empece con componentes server-side. Pros, contras y codigo.',
            ],
            [
                'cat' => 'Carrera',
                'date' => '02 ABR 2026',
                'readTime' => '4 min',
                'title' => 'El sindrome del impostor del programador',
                'excerpt' => 'Diez anos haciendo esto y todavia dudo de mi mismo. Como aprendi a convivir y por que no es solo cosa de juniors.',
            ],
            [
                'cat' => 'IA',
                'date' => '20 MAR 2026',
                'readTime' => '8 min',
                'title' => 'Construi mi propio Copilot con Laravel y OpenAI',
                'excerpt' => 'Tutorial paso a paso de como armar un asistente de codigo integrado en tu app, con streaming de respuestas y rate limiting.',
            ],
            [
                'cat' => 'Docencia',
                'date' => '10 MAR 2026',
                'readTime' => '5 min',
                'title' => 'Lo que aprendi ensenando a 500 alumnos',
                'excerpt' => 'Patrones que se repiten, las preguntas que mas cuestan, y por que a veces dejar fallar al alumno es la mejor leccion.',
            ],
            [
                'cat' => 'Vue',
                'date' => '28 FEB 2026',
                'readTime' => '7 min',
                'title' => 'Vue 3 + Composition API: cuando usarla',
                'excerpt' => 'No todo proyecto necesita la Composition API. Una guia pragmatica basada en proyectos reales en produccion.',
            ],
            [
                'cat' => 'Off-topic',
                'date' => '14 FEB 2026',
                'readTime' => '3 min',
                'title' => 'Mi setup de developer + creador de contenido',
                'excerpt' => 'Camaras, micros, software, atajos de teclado y por que uso una iluminacion que parece exagerada.',
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

        $this->youtubeVideos = [
            ['featured' => true, 'title' => 'Curso completo de Laravel 11 desde cero (4 horas)', 'duration' => '4:12:34', 'views' => '142K', 'ago' => 'hace 2 semanas', 'bg' => '#110090', 'accent' => '#ffc932', 'emoji' => '🅻'],
            ['title' => 'Construyendo un chatbot con IA en Laravel', 'duration' => '38:21', 'views' => '24K', 'ago' => 'hace 1 mes', 'bg' => '#ffc932', 'accent' => '#110090', 'emoji' => '🤖'],
            ['title' => 'Livewire 3: lo que nadie te explica', 'duration' => '22:08', 'views' => '67K', 'ago' => 'hace 1 mes', 'bg' => '#4c2e84', 'accent' => '#fbdc6d', 'emoji' => '⚡'],
            ['title' => 'Mi setup de profesor + streamer en 2026', 'duration' => '15:42', 'views' => '18K', 'ago' => 'hace 2 meses', 'bg' => '#fbdc6d', 'accent' => '#110090', 'emoji' => '🎥'],
            ['title' => 'PHP no esta muerto (y aqui lo demuestro)', 'duration' => '28:15', 'views' => '89K', 'ago' => 'hace 3 meses', 'bg' => '#5f3a92', 'accent' => '#ffc932', 'emoji' => '🐘'],
        ];

        $this->twitchStreams = [
            ['live' => true, 'title' => 'Construyendo un SaaS con Laravel + Livewire EN VIVO', 'category' => 'Software & Game Development', 'viewers' => '1.2K', 'ago' => 'ahora', 'bg' => '#9146ff', 'accent' => '#ffc932', 'emoji' => '🔴'],
            ['title' => 'Refactor brutal: limpiando codigo de hace 5 anos', 'category' => 'Software Development', 'duration' => '3:42:18', 'views' => '8.4K', 'ago' => 'hace 2 dias', 'bg' => '#110090', 'accent' => '#ffc932', 'emoji' => '🧹'],
            ['title' => 'Aprendiendo Vue 3 con la comunidad', 'category' => 'Software Development', 'duration' => '2:18:05', 'views' => '5.7K', 'ago' => 'hace 5 dias', 'bg' => '#4c2e84', 'accent' => '#fbdc6d', 'emoji' => '△'],
            ['title' => 'Code Review en vivo de proyectos de la comunidad', 'category' => 'Just Chatting', 'duration' => '4:05:32', 'views' => '12.1K', 'ago' => 'hace 1 semana', 'bg' => '#ffc932', 'accent' => '#110090', 'emoji' => '👀'],
        ];

        $this->socials = [
            ['name' => 'YouTube', 'handle' => '@acenagadev', 'url' => 'https://youtube.com/@acenagadev', 'icon' => 'youtube'],
            ['name' => 'Instagram', 'handle' => '@acenaga.dev', 'url' => 'https://instagram.com/acenaga.dev', 'icon' => 'instagram'],
            ['name' => 'Twitch', 'handle' => 'acenagadev', 'url' => 'https://twitch.tv/acenagadev', 'icon' => 'twitch'],
            ['name' => 'Kick', 'handle' => 'acenagadev', 'url' => 'https://kick.com/acenagadev', 'icon' => 'kick'],
            ['name' => 'X / Twitter', 'handle' => '@acenagadev', 'url' => 'https://x.com/acenagadev', 'icon' => 'x'],
            ['name' => 'Threads', 'handle' => '@acenaga.dev', 'url' => 'https://threads.net/@acenaga.dev', 'icon' => 'threads'],
        ];

        $this->taglines = [
            'Profesor que tambien compila',
            'Code, cafe y caos en partes iguales',
            'Enseno Laravel y a no asustarse del error 500',
            'Devuelvo el corazon a los semicolons',
            'PHP, Vue y mucha paciencia',
            'Bug-driven development desde 2014',
        ];
    }

    public function render()
    {
        return view('livewire.mockup-page');
    }
}
