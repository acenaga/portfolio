<?php

namespace App\Filament\Resources\SiteStats\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class SiteStatForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('value')
                    ->label('Valor (ej. 10+)')
                    ->required()
                    ->maxLength(10),
                TextInput::make('label')
                    ->label('Etiqueta')
                    ->required()
                    ->maxLength(64)
                    ->columnSpanFull(),
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
