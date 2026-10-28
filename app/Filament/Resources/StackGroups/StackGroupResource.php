<?php

namespace App\Filament\Resources\StackGroups;

use App\Filament\Resources\StackGroups\Pages\CreateStackGroup;
use App\Filament\Resources\StackGroups\Pages\EditStackGroup;
use App\Filament\Resources\StackGroups\Pages\ListStackGroups;
use App\Filament\Resources\StackGroups\RelationManagers\ToolsRelationManager;
use App\Filament\Resources\StackGroups\Schemas\StackGroupForm;
use App\Filament\Resources\StackGroups\Tables\StackGroupsTable;
use App\Models\StackGroup;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class StackGroupResource extends Resource
{
    protected static ?string $model = StackGroup::class;

    protected static ?string $modelLabel = 'grupo del stack';

    protected static ?string $pluralModelLabel = 'grupos del stack';

    protected static UnitEnum|string|null $navigationGroup = 'Contenido';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCube;

    public static function form(Schema $schema): Schema
    {
        return StackGroupForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return StackGroupsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            ToolsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListStackGroups::route('/'),
            'create' => CreateStackGroup::route('/create'),
            'edit' => EditStackGroup::route('/{record}/edit'),
        ];
    }
}
