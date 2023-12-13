<?php

namespace App\Filament\Resources\SubBrandsResource\Pages;

use App\Filament\Resources\SubBrandsResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageSubBrands extends ManageRecords
{
    protected static string $resource = SubBrandsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
