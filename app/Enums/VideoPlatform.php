<?php

namespace App\Enums;

enum VideoPlatform: string
{
    case YouTube = 'youtube';
    case Twitch = 'twitch';

    public function label(): string
    {
        return match ($this) {
            self::YouTube => 'YouTube',
            self::Twitch => 'Twitch',
        };
    }
}
