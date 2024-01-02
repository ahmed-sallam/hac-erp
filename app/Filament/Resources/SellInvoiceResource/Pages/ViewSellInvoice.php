<?php

namespace App\Filament\Resources\SellInvoiceResource\Pages;

use App\Filament\Resources\SellInvoiceResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewSellInvoice extends ViewRecord
{
    protected static string $resource = SellInvoiceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
