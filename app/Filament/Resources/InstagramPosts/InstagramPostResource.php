<?php

namespace App\Filament\Resources\InstagramPosts;

use App\Filament\Resources\InstagramPosts\Pages\ManageInstagramPosts;
use App\Models\InstagramPost;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Resources\Resource;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use UnitEnum;

class InstagramPostResource extends Resource
{
    protected static ?string $model = InstagramPost::class;

    protected static ?string $modelLabel = 'post de Instagram';

    protected static ?string $pluralModelLabel = 'posts de Instagram';

    protected static UnitEnum|string|null $navigationGroup = 'Contenido';

    protected static ?string $navigationLabel = 'Instagram';

    protected static ?int $navigationSort = 91;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedPhoto;

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('published_at', 'desc')
            ->columns([
                ImageColumn::make('thumbnail_url')
                    ->label('')
                    ->getStateUsing(fn (InstagramPost $record): ?string => $record->thumbnail_url ?: $record->media_url)
                    ->circular(false)
                    ->width('56px'),
                TextColumn::make('caption')
                    ->label('Caption')
                    ->limit(60)
                    ->wrap()
                    ->searchable(),
                TextColumn::make('media_type')
                    ->label('Tipo')
                    ->badge(),
                TextColumn::make('like_count')
                    ->label('Likes')
                    ->numeric()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('comments_count')
                    ->label('Comentarios')
                    ->numeric()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('published_at')
                    ->label('Publicado')
                    ->date('d M Y H:i')
                    ->sortable(),
                ToggleColumn::make('is_visible')
                    ->label('Visible en el home'),
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
            ->emptyStateHeading('Sin posts de Instagram sincronizados')
            ->emptyStateDescription('Configurá INSTAGRAM_USER_ID/INSTAGRAM_ACCESS_TOKEN y corré "php artisan instagram:sync".');
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageInstagramPosts::route('/'),
        ];
    }
}
