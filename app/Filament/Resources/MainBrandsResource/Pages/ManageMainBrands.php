<?php

namespace App\Filament\Resources\MainBrandsResource\Pages;

use App\Filament\Resources\MainBrandsResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageMainBrands extends ManageRecords
{
    protected static string $resource = MainBrandsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
