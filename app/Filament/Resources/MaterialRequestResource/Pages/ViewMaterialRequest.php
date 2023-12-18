<?php

namespace App\Filament\Resources\MaterialRequestResource\Pages;

use App\Filament\Resources\MaterialRequestResource;
use App\Models\MaterialRequest;
use Filament\Actions;
use Filament\Infolists\Components\Actions\Action;
use Filament\Infolists\Components\Grid;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ViewEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Support\Facades\App;

class ViewMaterialRequest extends ViewRecord
{
    protected static string $resource = MaterialRequestResource::class;

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
                Section::make(trans('material_request.request_details'))
//                    ->headerActions([
//                        Action::make('edit')
//                            ->url(
//                                fn(
//                                    MaterialRequest $record
//                                ): string => route(
//                                    'filament.dashboard.resources.material-requests.edit', $record
//                                )),
//                    ])
                    ->schema([

                        TextEntry::make('order_number')->label(trans('material_request.order_number')),
                        TextEntry::make('request_date')->label(trans('material_request.request_date'))->date(),
                        TextEntry::make('status')->label(trans('material_request.status'))
                            ->badge()
                            ->color(fn (string $state): string => match ($state) {
                                'pending' => 'gray',
                                'pricing' => 'info',
                                'quotation' => 'warning',
                                'approved' => 'success',
                                'rejected' => 'danger',
                            }),
                        TextEntry::make($currentLocal == 'ar' ?'store.name_ar':'store.name_en')->label(trans('stores.store')),
                        TextEntry::make($currentLocal == 'ar' ?'employee.name_ar': 'employee.name_en')->label(trans('material_request.employee')),
                        TextEntry::make('updated_at')->label(trans('material_request.last_update'))->date(),
                    ])->columns(2),
//                Section::make('Items')->label('Items')
//                ->schema([

                RepeatableEntry::make('requestLines')->label(trans('material_request.items'))
                    ->schema([
                    Grid::make(['default' => 5, 'sm'=>2, 'lg'=>5])
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
//                ]),
            ]);
    }
}
