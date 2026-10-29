<?php

namespace App\Filament\Resources\Posts;

use App\Filament\Resources\Posts\Pages\ManagePosts;
use App\Models\Post;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Resources\Resource;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use UnitEnum;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static ?string $modelLabel = 'post externo';

    protected static ?string $pluralModelLabel = 'posts externos';

    protected static UnitEnum|string|null $navigationGroup = 'Contenido';

    protected static ?string $navigationLabel = 'Posts (tu blog)';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedNewspaper;

    protected static ?int $navigationSort = 90;

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('published_at', 'desc')
            ->columns([
                TextColumn::make('title')
                    ->label('Título')
                    ->searchable()
                    ->wrap(),
                TextColumn::make('tags')
                    ->label('Etiquetas')
                    ->badge(),
                TextColumn::make('published_at')
                    ->label('Publicado')
                    ->date('d M Y')
                    ->sortable(),
                ToggleColumn::make('is_visible')
                    ->label('Visible en el home'),
                TextColumn::make('fetched_at')
                    ->label('Sincronizado')
                    ->since()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateHeading('Sin posts sincronizados')
            ->emptyStateDescription('Corré "php artisan posts:sync" cuando la API del blog esté configurada.');
    }

    public static function getPages(): array
    {
        return [
            'index' => ManagePosts::route('/'),
        ];
    }
}
