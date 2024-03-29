<?php

namespace App\Filament\Resources\CustomerRequestResource\Pages;

use Filament\Actions;
use Filament\Infolists\Infolist;
use Illuminate\Support\Facades\App;

use Filament\Infolists\Components\Grid;
use Filament\Resources\Pages\ViewRecord;
use Filament\Forms\Components\RichEditor;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\RepeatableEntry;
use App\Filament\Resources\CustomerRequestResource;

class ViewCustomerRequest extends ViewRecord
{
    protected static string $resource = CustomerRequestResource::class;

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
                TextEntry::make('number')
                    ->inlineLabel()
                    ->label(trans('sales.request_number')),
                TextEntry::make('date')
                    ->label(trans('sales.request_date'))
                    ->inlineLabel()
                    ->date(),
                TextEntry::make($currentLocal == 'ar' ? 'partner.name_ar' : 'partner.name_en')
                    ->inlineLabel()
                    ->label(trans('partner.customer')),
                TextEntry::make($currentLocal == 'ar' ? 'employee.name_ar' : 'employee.name_en')
                    ->inlineLabel()
                    ->label(trans('material_request.employee')),
                TextEntry::make('notes')
                    ->markdown()
                    ->inlineLabel()
                    ->label(trans('sales.notes'))
                    ->columnSpan(2),



                RepeatableEntry::make('requestLines')
                    ->label(trans('material_request.items'))
                    ->schema([
                        Grid::make(['default' => 6])
                            ->schema([
                                TextEntry::make('item.item_number')->label(trans('material_request.item_number')),
                                TextEntry::make($currentLocal == 'ar' ? 'item.mainBrand.name_ar' : 'item.mainBrand.name_en')->label(trans('brands.main_brand')),
                                TextEntry::make($currentLocal == 'ar' ? 'item.subBrand.name_ar' : 'item.subBrand.name_en')->label(trans('brands.sub_brand')),
                                TextEntry::make($currentLocal == 'ar' ? 'item.country.name_ar' : 'item.country.name_en')->label(trans('material_request.country')),
                                TextEntry::make($currentLocal == 'ar' ? 'store.name_ar' : 'store.name_en')->label(trans('stores.store')),
                                TextEntry::make('quantity')->label(trans('material_request.quantity')),
                            ]),

                    ])
                    ->columnSpan('full'),
            ]);
    }
}
