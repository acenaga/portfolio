<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carlos Ferrer · acenagadev — Profesor, dev y creador</title>
    <meta name="description" content="Profesor en DaVinci, desarrollador web full-stack con 10+ años de experiencia y creador de contenido sobre Laravel, Vue y desarrollo web.">
    @php
        $carlosImage = 'data:image/jpeg;base64,'.base64_encode(
            file_get_contents(resource_path('images/mockup/carlos.jpg'))
        );
    @endphp
    <link rel="stylesheet" href="{{ asset('mockup/styles.css') }}">
</head>
<body>
    <livewire:mockup-page :carlos-image="$carlosImage" />
    <script src="{{ asset('mockup/livewire.js') }}" defer></script>
</body>
</html>
