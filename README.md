# acenaga.dev — Portfolio autogestionable

Portfolio de Carlos Ferrer (profesor, dev full-stack y creador de contenido), construido sobre **Laravel 13 + Livewire 4 + Filament 5**. El diseño (neo-brutalista con tokens CSS propios) es una landing de una sola página gestionable desde `/admin`, y las secciones de redes (blog, videos, Instagram) provienen de las redes propias vía API.

## Stack

| Pieza | Elección |
|---|---|
| Front | Livewire 4 (un solo componente `HomePage`), CSS y JS escritos a mano en `public/mockup/` |
| Panel | Filament 5 en `/admin` (login propio, labels en español) |
| Contenido gestionado | MariaDB + modelos Eloquent + Resources de Filament |
| Contenido externo | Tablas espejo sincronizadas por comandos programados |
| Settings / SEO | `spatie/laravel-settings` (`SiteSettings`) |
| Media | `spatie/laravel-medialibrary` (modelos `Site`: hero, about opcional, og:image) |
| Tests | Pest 5 / PHPUnit 13 |

## Arquitectura de contenido

Hay **dos mundos bien separados**:

### 1. Gestionado en este proyecto (Filament CRUD en MariaDB)

| Entidad | Modelos | Dónde vive |
|---|---|---|
| Proyectos | `Project` | Sección #projects |
| Materias | `Course` + enum `CourseLevel` | Sección #classes |
| Redes sociales | `SocialLink` | Sección #contact |
| Estadísticas | `SiteStat` | Stats del about |
| Stack | `StackGroup` + `StackTool` | Sección #stack (grupos + relation manager de tools) |
| Videos | `Video` + enum `VideoPlatform` (youtube/twitch) | Secciones #youtube y #twitch |
| Imágenes del sitio | `Site` (singleton) | hero, about (slot opcional), og:image |

Toda entidad lleva `sort` (orden drag & drop en el panel) y `is_published` (publicar/ocultar).

### 2. Proviene de las redes propias (solo lectura, espejo sincronizado)

| Fuente | Espejo | Sync | Credenciales |
|---|---|---|---|
| Blog (otra página) | `Post` | `posts:sync` cada hora | `PORTFOLIO_BLOG_API_URL`, `PORTFOLIO_BLOG_API_TOKEN` |
| YouTube | `Video` | `videos:sync-youtube` diario | `YOUTUBE_API_KEY`, `PORTFOLIO_YOUTUBE_HANDLE` |
| Twitch | `Video` (misma tabla, `platform=twitch`) | `videos:sync-twitch` diario | `TWITCH_CLIENT_ID`, `TWITCH_CLIENT_SECRET`, `PORTFOLIO_TWITCH_LOGIN` |
| Instagram | `InstagramPost` | `instagram:sync` cada hora | `INSTAGRAM_USER_ID`, `INSTAGRAM_ACCESS_TOKEN` |

Las tablas espejo son **local-first**: si el origen se cae, el portfolio sigue funcionando con la última sync. En el panel aparecen de solo lectura con un toggle "Visible en el home" — se cura qué mostrar sin editar la fuente. Sin credenciales, los sync son no-op con aviso (y el panel sigue operable a mano para videos).

#### Contrato de la API del blog

```
GET /api/posts                                    (Authorization: Bearer <token>)
→ { "data": [ { slug, title, url, published_at,  // obligatorios
              excerpt, tags, cover_url }         // opcionales
           ],
    "meta": { "next_page_url": "..." | null } }
```

### Lectura con cache

`App\Services\PortfolioContent` expone todas las colecciones con `Cache::rememberForever`. Los observers (`PortfolioContentObserver` en cada modelo via `#[ObservedBy]`) vacían la cache con cualquier save/delete — sea desde Filament, tinker o seeders. Por eso el home refleja las ediciones al instante.

**Ojo**: `config/cache.php` define `serializable_classes` como una allowlist explícita — el portfolio cachea modelos Eloquent, y con el default `false` del starter kit la deserialización rompería. Si se agrega una nueva entidad cacheada, sumar su clase ahí.

## Imágenes

El modelo singleton `Site` (HasMedia) maneja tres colecciones:

- `hero` — foto de presentación (servida con `fetchpriority="high"` + atributos `width/height` para cero CLS)
- `about` — foto "en acción", **opcional**: si no hay, la sección del about se muestra solo texto
- `og` — imagen para compartir, con conversión automática a 1200×630

Se suben desde **Ajustes del sitio** en `/admin`.

El título y la descripción de SEO viven en `SiteSettings`; la `og:image` y la imagen del hero son media de `Site`, y se apuntan en el `<head>` con fallback al placeholder.

Además del SEO, en settings viven los taglines rotativos del hero, los párrafos del about y el texto del footer — la copy editorial es contenido, no código.

## Panel de administración

`/admin` (Filament) con login propio y 2FA heredado de Fortify. El acceso está limitado por `User::is_admin` (`canAccessPanel`). Se crea el usuario admin con:

```env
ADMIN_EMAIL=tu@email.com
ADMIN_PASSWORD=una-contraseña
```

y `php artisan db:seed --force` (`AdminUserSeeder` es no-op si no hay variables definidas).

## Deploy

- **Entornos**: `dev.acenaga.dev` (staging, rama `develop`) y `acenaga.dev` (producción, rama `master`) — alojados en **Forge**, server `ctu-5`.
- **Flujo**: se trabaja y se prueba contra `develop`; la suite pasa primero; `master` solo con la suite verde. El push a `master` dispara el auto-deploy de Forge (release-based, downtime ~0).
- Las migraciones corren con el script de deploy; los syncs no requieren worker (`QUEUE_CONNECTION=sync` — las conversiones de media van inline; si se migrara a jobs de verdad, hay que crear el daemon en Forge).
- El scheduler (`routes/console.php`) corre en producción los syncs programados.

### Puesta en marcha de un entorno nuevo

```bash
php artisan migrate
php artisan db:seed --force     # contenido inicial + admin (si hay vars)
php artisan storage:link        # para las imágenes de media library
```

## Desarrollo

```bash
composer install && npm install && npm run build

vendor/bin/pest --compact       # suite completa (~55 tests)
vendor/bin/pint --dirty         # estilo (corrige)

php artisan posts:sync          # syncs manuales (no-op sin credenciales)
php artisan videos:sync-youtube
php artisan videos:sync-twitch
php artisan instagram:sync
php artisan instagram:refresh-token   # renueva el token IG de larga vida (~60 días)
```

### Detalles técnicos que muerden

- La vista/copy editorial vive en `SiteSettings`; lo estructural (nav, títulos de sección) queda en `HomePage::mount()`.
- Los colores decorativos (thumbs, cards) son **rotación CSS por nth-child**, no datos — los datos son datos.
- Frontend en `public/mockup/` (CSS y JS vanilla); el HTML se sirve desde las blade, no hay build para el sitio público.
- `laravel/pao` convierte la salida de Pest a JSON para agentes; con `PAO_DISABLE=1` se ve la salida humana.

## Roadmap abierto

- API del blog en producción (`/api/posts` de la otra página) → activar sync de posts
- Keys de YouTube/Twitch → activar sync de videos
- App de Meta + token IG → activar sync de Instagram
