<?php

namespace App\Filament\Resources\SocialLinks\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class SocialLinkForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nombre')
                    ->required()
                    ->maxLength(255),
                TextInput::make('handle')
                    ->label('Usuario')
                    ->maxLength(255),
                TextInput::make('url')
                    ->url()
                    ->required(),
                TextInput::make('icon')
                    ->label('Ícono')
                    ->hint('Nombre del ícono del sitio: youtube, instagram, twitch, kick, x, threads')
                    ->maxLength(32)
                    ->required(),
                TextInput::make('sort')
                    ->label('Orden')
                    ->numeric()
                    ->default(0)
                    ->required(),
                Toggle::make('is_published')
                    ->label('Publicado')
                    ->default(true),
            ]);
    }
}
