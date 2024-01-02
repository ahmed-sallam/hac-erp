<?php

namespace App\Filament\Resources\SellInvoiceResource\Pages;

use App\Filament\Resources\SellInvoiceResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSellInvoice extends EditRecord
{
    protected static string $resource = SellInvoiceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
