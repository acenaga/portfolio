<?php

namespace App\Filament\Resources\Courses\Schemas;

use App\Enums\CourseLevel;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class CourseForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->label('Título')
                    ->required()
                    ->maxLength(255),
                TextInput::make('tag')
                    ->label('Etiqueta (ej. HTML · CSS)')
                    ->maxLength(255),
                Select::make('level')
                    ->label('Nivel')
                    ->options(CourseLevel::class)
                    ->required(),
                TextInput::make('hours')
                    ->label('Horas')
                    ->numeric()
                    ->minValue(1)
                    ->maxValue(999)
                    ->required(),
                Textarea::make('description')
                    ->label('Descripción')
                    ->required()
                    ->rows(3)
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
