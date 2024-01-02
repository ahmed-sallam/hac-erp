<?php

namespace App\Filament\Resources\SellQuotationResource\Pages;

use App\Filament\Resources\SellQuotationResource;
use Filament\Actions;
use Filament\Infolists\Components\Grid;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Pages\ViewRecord;
use Filament\Tables\Table;
use Illuminate\Support\Facades\App;

class ViewSellQuotation extends ViewRecord
{
    protected static string $resource = SellQuotationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
    public function infolist(Infolist $infolist): Infolist
    {
        $currentLocal = App::currentLocale();

        return $infolist
            ->schema([
                Section::make(trans('sales.quotation_details'))
                    ->schema([
                        TextEntry::make('quotation_number')
                            ->label(trans('sales.quotation_number')),
                        TextEntry::make('status')->label(trans('material_request.status'))
                            ->badge()
                            ->color(fn(string $state): string => match ($state) {
                                'under_process' => 'gray',
                                'completed' => 'success',
                                'rejected' => 'danger',
                            }),
                        TextEntry::make('quotation_date')
                            ->label(trans('sales.quotation_date'))
                            ->date(),
                        TextEntry::make($currentLocal == 'ar' ? 'partner.name_ar':'partner.name_en')->label(trans('partner.customer')),
                        TextEntry::make('updated_at')->label(trans('material_request.last_update'))->date(),
                    ])->columns(2),

                RepeatableEntry::make('quotationLines')->label(trans('material_request.items'))
                    ->schema([
                        Grid::make(['default' => 2, 'sm' => 2, 'lg' => 7])
                            ->schema(
                                [
                                    TextEntry::make('item.item_number')->label(trans('material_request.item_number')),
                                    TextEntry::make($currentLocal == 'ar' ?'item.mainBrand.name_ar':'item.mainBrand.name_en')->label(trans('brands.main_brand')),
                                    TextEntry::make($currentLocal == 'ar' ?'item.subBrand.name_ar':'item.subBrand.name_en')->label(trans('brands.sub_brand')),
                                    TextEntry::make($currentLocal == 'ar' ?'item.country.name_ar': 'item.country.name_en')->label(trans('material_request.country')),
                                    TextEntry::make('quantity')->label(trans('material_request.quantity')),
                                    TextEntry::make('price')->label(trans('purchase_quotation.price')),
                                    TextEntry::make('vat')->label(trans('purchase_quotation.vat')),

                                ]
                            ),
                    ])->grid(1)->columnSpan('full')
//                ]),
            ]);
    }
}
