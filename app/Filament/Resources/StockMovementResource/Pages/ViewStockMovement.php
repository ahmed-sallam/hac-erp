<?php

namespace App\Filament\Resources\StockMovementResource\Pages;

use App\Filament\Resources\StockMovementResource;
use Filament\Actions;
use Filament\Infolists\Components\Grid;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Support\Facades\App;

class ViewStockMovement extends ViewRecord
{
    protected static string $resource = StockMovementResource::class;

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
                Section::make(trans('stock.movement_details'))
                    ->schema([
                        TextEntry::make('id')->inlineLabel(),
                        TextEntry::make('movement_type')
                            ->label(trans('stock.movement_type'))->inlineLabel(),
                        TextEntry::make('movement_date')
                            ->label(trans('stock.movement_date'))
                            ->date()->inlineLabel(),
                        TextEntry::make($currentLocal == 'ar' ? 'sourceStore.name_ar':'sourceStore.name_en')
                            ->label(trans('stock.source_store'))->inlineLabel(),
                        TextEntry::make($currentLocal == 'ar' ? 'destinationStore.name_ar':'destinationStore.name_en')
                            ->label(trans('stock.destination_store'))->inlineLabel(),
                        TextEntry::make($currentLocal == 'ar' ? 'employee.name_ar':'employee.name_en')
                            ->label(trans('material_request.employee'))->inlineLabel(),
                        TextEntry::make('reference')
                            ->label(trans('stock.reference'))->inlineLabel(),
                        TextEntry::make('updated_at')->label(trans('material_request.last_update'))->date()->inlineLabel(),
                    ])->columns(2),

                RepeatableEntry::make('movementLines')->label(trans('material_request.items'))
                    ->schema([
                        Grid::make(['default' => 5,  'lg' => 5])
                            ->schema(
                                [
                                    TextEntry::make('item.item_number')->label(trans('material_request.item_number')),
                                    TextEntry::make($currentLocal == 'ar' ?'item.mainBrand.name_ar':'item.mainBrand.name_en')->label(trans('brands.main_brand')),
                                    TextEntry::make($currentLocal == 'ar' ?'item.subBrand.name_ar':'item.subBrand.name_en')->label(trans('brands.sub_brand')),
                                    TextEntry::make($currentLocal == 'ar' ?'item.country.name_ar': 'item.country.name_en')->label(trans('material_request.country')),
                                    TextEntry::make('quantity')->label(trans('material_request.quantity')),

                                ]
                            ),
                    ])->grid(1)->columnSpan('full')
            ]);
    }
}
