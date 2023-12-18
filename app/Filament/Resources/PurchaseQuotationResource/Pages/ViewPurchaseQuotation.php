<?php

namespace App\Filament\Resources\PurchaseQuotationResource\Pages;

use App\Filament\Resources\PurchaseQuotationResource;
use App\Models\MaterialRequest;
use Filament\Actions;
use Filament\Infolists\Components\Actions\Action;
use Filament\Infolists\Components\Grid;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Support\Facades\App;

class ViewPurchaseQuotation extends ViewRecord
{
    protected static string $resource = PurchaseQuotationResource::class;

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
                Section::make(trans('purchase_quotation.quotation_details'))
                    ->schema([
                        TextEntry::make('materialRequest.order_number')
                            ->label(trans('material_request.order_number')),
                        TextEntry::make('quotation_number')
                            ->label(trans('purchase_quotation.quotation_number')),
                        TextEntry::make('status')->label(trans('material_request.status'))
                            ->badge()
                            ->color(fn(string $state): string => match ($state) {
                                'pending' => 'gray',
                                'completed' => 'success',
                                'rejected' => 'danger',
                            }),
                        TextEntry::make('quotation_date')
                            ->label(trans('purchase_quotation.quotation_date'))
                            ->date(),
                        TextEntry::make($currentLocal == 'ar' ? 'partner.name_ar':'partner.name_en')->label(trans('partner.supplier')),
                        TextEntry::make('updated_at')->label(trans('material_request.last_update'))->date(),
                    ])->columns(2),
//                Section::make('Items')->label('Items')
//                ->schema([

                RepeatableEntry::make('quotationLines')->label(trans('material_request.items'))
                    ->schema([
                        Grid::make(['default' => 7, 'sm' => 2, 'lg' => 7])
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
