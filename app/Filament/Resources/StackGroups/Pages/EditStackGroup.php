<?php

namespace App\Filament\Resources\StackGroups\Pages;

use App\Filament\Resources\StackGroups\StackGroupResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditStackGroup extends EditRecord
{
    protected static string $resource = StackGroupResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
