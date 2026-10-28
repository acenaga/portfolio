<?php

namespace App\Filament\Resources\StackGroups\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class StackGroupForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('label')
                    ->label('Título del grupo')
                    ->required()
                    ->maxLength(255)
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
