<?php

namespace App\Filament\Resources\SellQuotationResource\Pages;

use App\Filament\Resources\SellQuotationResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSellQuotations extends ListRecords
{
    protected static string $resource = SellQuotationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
