<?php

namespace App\Filament\Resources\SellInvoiceResource\Pages;

use Filament\Actions;
use Filament\Forms\Get;
use Filament\Infolists\Infolist;
use Illuminate\Support\Facades\App;
use Filament\Infolists\Components\Grid;
use Illuminate\Database\Eloquent\Model;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use App\Filament\Resources\SellInvoiceResource;
use Filament\Infolists\Components\RepeatableEntry;

class ViewSellInvoice extends ViewRecord
{
    protected static string $resource = SellInvoiceResource::class;

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
                Section::make(trans('sales.invoice_details'))
                    ->schema([
                        TextEntry::make('invoice_number')
                            ->label(trans('sales.invoice_number'))->inlineLabel(),
                        TextEntry::make('invoice_date')
                            ->label(trans('sales.invoice_date'))
                            ->date()->inlineLabel(),
                        TextEntry::make('delivery_date')
                            ->label(trans('sales.delivery_date'))
                            ->date()->inlineLabel(),
                        TextEntry::make('invoice_type')
                            ->label(trans('sales.invoice_type'))->inlineLabel(),
                        TextEntry::make($currentLocal == 'ar' ? 'partner.name_ar' : 'partner.name_en')
                            ->label(trans('partner.customer'))->inlineLabel(),
                        TextEntry::make($currentLocal == 'ar' ? 'employee.name_ar' : 'employee.name_en')
                            ->label(trans('material_request.employee'))->inlineLabel(),
                        TextEntry::make('customerRequest.number')
                            ->label(trans('sales.customer_request'))->inlineLabel(),
                        TextEntry::make('sellQuotation.quotation_number')
                            ->label(trans('sales.quotation_number'))->inlineLabel(),
                        TextEntry::make('stock_movement_id')->inlineLabel(),
                        TextEntry::make('reference')
                            ->label(trans('sales.reference'))->inlineLabel(),
                        TextEntry::make('notes')
                            ->label(trans('sales.notes'))
                            ->markdown()
                            ->columnSpan(2),

                    ])->columns(2),
                Section::make()
                    ->schema([
                        RepeatableEntry::make('invoiceLines')
                            ->label(trans('material_request.items'))
                            ->schema([
                                Grid::make(['default' => 10])
                                    ->schema([
                                        TextEntry::make('item.item_number')->label(trans('material_request.item_number')),
                                        TextEntry::make($currentLocal == 'ar' ? 'item.mainBrand.name_ar' : 'item.mainBrand.name_en')->label(trans('brands.main_brand')),
                                        TextEntry::make($currentLocal == 'ar' ? 'item.subBrand.name_ar' : 'item.subBrand.name_en')->label(trans('brands.sub_brand')),
                                        TextEntry::make($currentLocal == 'ar' ? 'item.country.name_ar' : 'item.country.name_en')->label(trans('material_request.country')),
                                        TextEntry::make($currentLocal == 'ar' ? 'store.name_ar' : 'store.name_en')->label(trans('stores.store')),
                                        TextEntry::make('quantity')->label(trans('material_request.quantity')),
                                        TextEntry::make('price')->label(trans('purchase_quotation.price')),
                                        TextEntry::make('discount')->label(trans('sales.discount')),
                                        TextEntry::make('vat')->label(trans('purchase_quotation.vat')),
                                        TextEntry::make('line_total')
                                            ->label(trans('sales.line_total'))
                                            ->state(function (Model $record) {
                                                // dd($record);
                                                return $record->quantity * (($record->price - $record->discount) + $record->vat);
                                            }),

                                    ]),

                            ])
                            ->columnSpan('full'),
                    ]),

                Section::make(trans('sales.invoice_value'))
                    ->label(trans('sales.invoice_value'))
                    ->schema([

                        Grid::make()->schema([
                            TextEntry::make('sub_total')->label(trans('sales.sub_total')),
                            //                            ->afterStateUpdated(function($state, callable $set){
                            //                                dd($state);
                            ////                                $set('vat', (int)$state * 0.15);
                            //                            }),
                            TextEntry::make('discount')->label(trans('sales.discount')),
                            TextEntry::make('total')->label(trans('sales.total')),
                            TextEntry::make('vat')->label(trans('purchase_quotation.vat')),
                            TextEntry::make('net_total')->label(trans('purchase_quotation.vat')),
                        ])->columns(['default' => 5, 'sm' => 2, 'md' => 5, 'lg' => 5]),
                    ]),
            ]);
    }
}
