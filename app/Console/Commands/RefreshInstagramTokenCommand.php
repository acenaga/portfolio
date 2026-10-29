<?php

namespace App\Console\Commands;

use App\Integrations\InstagramApi;
use Illuminate\Console\Command;

class RefreshInstagramTokenCommand extends Command
{
    protected $signature = 'instagram:refresh-token';

    protected $description = 'Renueva el token de larga vida de Instagram e imprime el nuevo (se actualiza manualmente en el env)';

    public function handle(InstagramApi $instagramApi): int
    {
        $token = $instagramApi->refreshedToken();

        if (empty($token)) {
            $this->warn('No se pudo renovar el token (¿credentials/permisos?).');

            return self::FAILURE;
        }

        $this->info('Nuevo token de larga vida (actulizalo en el env del servidor y en Forge):');
        $this->line($token);

        return self::SUCCESS;
    }
}
