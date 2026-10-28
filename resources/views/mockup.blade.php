<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @php
        // Placeholder hasta que el backend provea los campos de SEO autogestionables.
        $seo = [
            'title' => 'Carlos Ferrer · acenagadev — Profesor, dev y creador',
            'description' => 'Profesor en DaVinci, desarrollador web full-stack con 10+ años de experiencia y creador de contenido sobre Laravel, Vue y desarrollo web.',
            'url' => url('/'),
            'image' => asset('mockup/og-cover.jpg'),
            'imageWidth' => 1080,
            'imageHeight' => 1080,
            'siteName' => 'acenaga.dev',
            'locale' => 'es_AR',
        ];
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
    @php
        $carlosImage = 'data:image/jpeg;base64,'.base64_encode(
            file_get_contents(resource_path('images/mockup/carlos.jpg'))
        );
    @endphp
    <link rel="stylesheet" href="{{ asset('mockup/styles.css').'?v='.filemtime(public_path('mockup/styles.css')) }}">
</head>
<body>
    <livewire:mockup-page :carlos-image="$carlosImage" />
    <script src="{{ asset('mockup/livewire.js') }}" defer></script>
</body>
</html>
