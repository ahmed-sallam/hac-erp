<?php

namespace App\Filament\Resources\SellQuotationResource\Pages;

use App\Filament\Resources\SellQuotationResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSellQuotation extends EditRecord
{
    protected static string $resource = SellQuotationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
