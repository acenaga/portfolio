<?php

namespace App\Filament\Resources\Videos\Schemas;

use App\Enums\VideoPlatform;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class VideoForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('platform')
                    ->label('Plataforma')
                    ->options(VideoPlatform::class)
                    ->required()
                    ->live(),
                TextInput::make('title')
                    ->label('Título')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),
                TextInput::make('external_id')
                    ->label('ID externo (YouTube/Twitch)')
                    ->maxLength(64),
                TextInput::make('url')
                    ->url()
                    ->required(),
                TextInput::make('thumbnail_url')
                    ->url()
                    ->label('URL del thumbnail'),
                TextInput::make('icon')
                    ->label('Ícono (placeholder hasta tener thumbnail)')
                    ->maxLength(10),
                TextInput::make('duration_seconds')
                    ->label('Duración en segundos')
                    ->numeric()
                    ->minValue(0),
                TextInput::make('views')
                    ->label('Vistas')
                    ->numeric()
                    ->minValue(0),
                DatePicker::make('published_at')
                    ->label('Fecha de publicación'),
                TextInput::make('category')
                    ->label('Categoría (Twitch)')
                    ->maxLength(255),
                Toggle::make('is_live')
                    ->label('En vivo ahora'),
                Toggle::make('is_featured')
                    ->label('Destacado'),
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
