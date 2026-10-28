<?php

namespace App\Filament\Resources\StackGroups\Pages;

use App\Filament\Resources\StackGroups\StackGroupResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListStackGroups extends ListRecords
{
    protected static string $resource = StackGroupResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
