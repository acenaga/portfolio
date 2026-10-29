<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @php
        // Los valores viven en SiteSettings y las imágenes en el modelo Site (gestionables desde /admin).
        $settings = app(App\Settings\SiteSettings::class);
        $site = App\Models\Site::query()->first();
        $seo = [
            'title' => $settings->seo_title,
            'description' => $settings->seo_description,
            'url' => url('/'),
            'image' => $site?->getFirstMediaUrl('og') ?: asset('mockup/og-cover.jpg'),
            'imageWidth' => 1200,
            'imageHeight' => 630,
            'siteName' => 'acenaga.dev',
            'locale' => 'es_AR',
        ];
        $heroImage = $site?->getFirstMediaUrl('hero') ?: asset('mockup/og-cover.jpg');
    @endphp
    <title>{{ $seo['title'] }}</title>
    <meta name="description" content="{{ $seo['description'] }}">
    <meta name="theme-color" content="#0a0050">
    <link rel="canonical" href="{{ $seo['url'] }}">

    <link rel="icon" href="{{ asset('favicon.ico') }}" sizes="any">
    <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">
    <link rel="apple-touch-icon" href="{{ asset('apple-touch-icon.png') }}">

    <meta property="og:type" content="website">
    <meta property="og:site_name" content="{{ $seo['siteName'] }}">
    <meta property="og:title" content="{{ $seo['title'] }}">
    <meta property="og:description" content="{{ $seo['description'] }}">
    <meta property="og:url" content="{{ $seo['url'] }}">
    <meta property="og:image" content="{{ $seo['image'] }}">
    <meta property="og:image:width" content="{{ $seo['imageWidth'] }}">
    <meta property="og:image:height" content="{{ $seo['imageHeight'] }}">
    <meta property="og:locale" content="{{ $seo['locale'] }}">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $seo['title'] }}">
    <meta name="twitter:description" content="{{ $seo['description'] }}">
    <meta name="twitter:image" content="{{ $seo['image'] }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700&family=JetBrains+Mono:wght@400;500;700&family=Fraunces:ital,wght@0,400;0,600;0,900;1,400;1,900&family=VT323&display=swap">
    <link rel="stylesheet" href="{{ asset('mockup/styles.css').'?v='.filemtime(public_path('mockup/styles.css')) }}">
</head>
<body>
    <livewire:home-page :hero-image="$heroImage" />
    <script src="{{ asset('mockup/livewire.js') }}" defer></script>
</body>
</html>
