<?php

namespace App\Filament\Resources\StoresResource\Pages;

use App\Filament\Resources\StoresResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditStores extends EditRecord
{
    protected static string $resource = StoresResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
