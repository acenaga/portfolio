<?php

namespace App\Filament\Resources\Projects\Schemas;

use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ProjectForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nombre')
                    ->required()
                    ->maxLength(255),
                Textarea::make('description')
                    ->label('Descripción')
                    ->required()
                    ->rows(3)
                    ->columnSpanFull(),
                TextInput::make('url')
                    ->url()
                    ->prefixIcon('heroicon-o-link')
                    ->required(),
                TextInput::make('icon')
                    ->label('Ícono (placeholder hasta tener screenshot)')
                    ->maxLength(10),
                TagsInput::make('tags')
                    ->label('Etiquetas')
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
