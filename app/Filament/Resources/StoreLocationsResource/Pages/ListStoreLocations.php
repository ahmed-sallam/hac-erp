<?php

namespace App\Filament\Resources\StoreLocationsResource\Pages;

use App\Filament\Resources\StoreLocationsResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListStoreLocations extends ListRecords
{
    protected static string $resource = StoreLocationsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
