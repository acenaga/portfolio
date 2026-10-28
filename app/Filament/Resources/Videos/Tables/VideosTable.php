<?php

namespace App\Filament\Resources\Videos\Tables;

use App\Enums\VideoPlatform;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class VideosTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->reorderable('sort')
            ->defaultSort('sort')
            ->columns([
                TextColumn::make('icon')
                    ->label('')
                    ->width('40px'),
                TextColumn::make('title')
                    ->label('Título')
                    ->searchable()
                    ->sortable()
                    ->wrap(),
                TextColumn::make('platform')
                    ->label('Plataforma')
                    ->badge(),
                TextColumn::make('category')
                    ->label('Categoría')
                    ->toggleable(),
                TextColumn::make('views')
                    ->label('Vistas')
                    ->numeric()
                    ->sortable()
                    ->toggleable(),
                IconColumn::make('is_live')
                    ->label('En vivo')
                    ->boolean()
                    ->toggleable(),
                IconColumn::make('is_featured')
                    ->label('Destacado')
                    ->boolean()
                    ->toggleable(),
                TextColumn::make('published_at')
                    ->label('Publicado')
                    ->date('d M Y')
                    ->sortable()
                    ->toggleable(),
                IconColumn::make('is_published')
                    ->label('Publicado')
                    ->boolean(),
            ])
            ->filters([
                SelectFilter::make('platform')
                    ->label('Plataforma')
                    ->options(VideoPlatform::class),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
