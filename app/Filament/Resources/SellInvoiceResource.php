<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Items;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\SellInvoice;
use Filament\Resources\Resource;
use Filament\Forms\Components\Grid;
use Illuminate\Support\Facades\App;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\RichEditor;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\SellInvoiceResource\Pages;
use App\Filament\Resources\SellInvoiceResource\RelationManagers;

class SellInvoiceResource extends Resource
{
    protected static ?string $model = SellInvoice::class;
    protected static ?int $navigationSort = 2;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        $currentLocal = App::currentLocale();

        return $form
            ->schema([
                TextInput::make('invoice_number')->label(trans('sales.invoice_number'))
                    ->disabled()
                    ->maxLength(20),
                DatePicker::make('invoice_date')->label(trans('sales.invoice_date'))
                    ->required()
                    ->date()
                    ->native(false),
                DatePicker::make('delivery_date')->label(trans('sales.delivery_date'))
                    ->required()
                    ->date()
                    ->native(false),
                Select::make('invoice_type')->label(trans('sales.invoice_type'))
                    ->options([
                        'cash' => 'cash',
                        'credit' => 'credit'
                    ])
                    ->required(),
                Select::make('partner_id')
                    ->relationship(name: 'partner', titleAttribute: $currentLocal == 'ar' ? 'name_ar' : 'name_en')->label(trans('partner.customer'))
                    ->native(false)
                    ->searchable()
                    ->preload()
                    ->required(),
                Select::make('employee_id')
                    ->relationship(name: 'employee', titleAttribute: $currentLocal == 'ar' ? 'name_ar' : 'name_en')->label(trans('material_request.employee'))
                    ->native(false)
                    ->searchable()
                    ->preload()
                    ->required(),
                Select::make('customer_request_id')
                    ->relationship(
                        name: 'customerRequest',
                        titleAttribute: 'number'
                    )
                    ->label(trans('sales.customer_request'))
                    ->native(false)
                    ->searchable()
                    ->live()
                    // ->afterStateUpdated(function ($state, Set $set, Get $get) {
                    //     self::updateRequestItems($state, $set, $get);
                    // })
                    ->preload(),
                Select::make('sell_quotation_id')
                    ->relationship(name: 'sellQuotation', titleAttribute: 'quotation_number')
                    ->label(trans('sales.quotation_number'))
                    ->native(false)
                    ->searchable()
                    ->preload(),
                Select::make('stock_movement_id')
                    ->relationship(name: 'stockMovement', titleAttribute: 'id')
                    // ->label(trans('sales.quotation_number'))
                    ->native(false)
                    ->searchable()
                    ->preload(),
                TextInput::make('reference')->label(trans('sales.reference'))
                    ->maxLength(20),
                RichEditor::make('notes')
                    ->label(trans('sales.notes'))->columnSpan(2),


                \Icetalker\FilamentTableRepeater\Forms\Components\TableRepeater::make('invoiceLines')
                    ->label(trans('material_request.items'))
                    ->relationship('invoiceLines')
                    ->schema([

                        Forms\Components\Select::make('item_id')
                            ->relationship(name: 'item', titleAttribute: 'item_number')
                            ->label(trans('material_request.item_number'))
                            ->getOptionLabelFromRecordUsing(
                                fn ($record) => "{$record->item_number} - {$record->mainBrand->name_ar} - {$record->subBrand->name_ar} - {$record->country->name_ar} "
                            )
                            ->disableOptionWhen(function ($value, $state, Get $get) {
                                return collect($get('../*.item_id'))
                                    ->reject(fn ($id) => $id == $state)
                                    ->filter()
                                    ->contains($value);
                            })
                            ->searchable()
                            ->preload()
                            ->live()
                            ->afterStateUpdated(function (Set $set, Get $get) {
                                self::setPriceVatLineTotal($set, $get);
                                // $state ? $set('price',  Items::find($state)->sale_price) : null; //////
                            })
                            ->required()
                            ->native(false),
                        Select::make('store_id')
                            ->relationship(
                                name: 'store',
                                titleAttribute: $currentLocal == 'ar' ? 'name_ar' : 'name_en',
                                modifyQueryUsing: fn (Builder $query) => $query->where('type', '!=', 'virtual')
                            )->label(trans('stores.store'))
                            ->searchable()
                            ->preload()
                            ->required()
                            ->native(false),
                        TextInput::make('quantity')->label(trans('material_request.quantity'))
                            ->required()
                            ->minValue(1)
                            ->default(1)
                            ->live()
                            ->reactive()
                            ->afterStateUpdated(function (Set $set, Get $get) {
                                self::setPriceVatLineTotal($set, $get);
                                // $state ? $set('price',  Items::find($state)->sale_price) : null; //////
                            })
                            ->numeric(),
                        TextInput::make('price')->label(trans('purchase_quotation.price'))
                            ->reactive()
                            ->readonly()
                            ->afterStateUpdated(function ($state,  Set $set) {
                                $set('vat', (int)$state * 0.15);
                                //                                dd($get('invoiceLines')[0]['quantity']);
                            })
                            //                            ->afterStateUpdated(function (Forms\Get $get, callable $set) {
                            ////                                dd($get('invoiceLines'));
                            //                                $set('sub_total', 10);
                            //
                            //                            })
                            ->numeric(),
                        TextInput::make('discount')->label(trans('sales.discount'))
                            ->minValue(0)
                            ->default(0)
                            ->live()
                            ->reactive()
                            ->afterStateUpdated(function (Set $set, Get $get) {
                                self::setPriceVatLineTotal($set, $get);
                                // $state ? $set('price',  Items::find($state)->sale_price) : null; //////
                            })
                            ->numeric(),
                        TextInput::make('vat')->label(trans('purchase_quotation.vat'))
                            ->readOnly()
                            ->numeric(),
                        TextInput::make('line_total')->label(trans('sales.line_total'))
                            ->readOnly()
                            ->numeric(),

                    ])
                    ->collapsible()
                    ->minItems(1)
                    ->columnSpan('full')
                    ->colStyles([
                        'item_id' => 'width: 30%;',
                        'store_id' => 'width: 15%;',
                    ]),

                Section::make(trans('sales.invoice_value'))
                    ->label(trans('sales.invoice_value'))
                    ->schema([

                        Grid::make()->schema([
                            TextInput::make('sub_total')->label(trans('sales.sub_total'))
                                ->numeric()
                                ->live()
                                ->readOnly(),
                            //                            ->afterStateUpdated(function($state, callable $set){
                            //                                dd($state);
                            ////                                $set('vat', (int)$state * 0.15);
                            //                            }),
                            TextInput::make('discount')->label(trans('sales.discount'))
                                ->numeric()
                                ->live()
                                ->readOnly(),
                            TextInput::make('total')->label(trans('sales.total'))
                                ->numeric()
                                ->live()
                                ->readOnly(),
                            TextInput::make('vat')->label(trans('purchase_quotation.vat'))
                                ->numeric()
                                ->live()
                                ->readOnly(),
                            TextInput::make('net_total')->label(trans('purchase_quotation.vat'))
                                ->numeric()
                                ->live()
                                ->readOnly(),
                        ])->columns(['default' => 5, 'sm' => 2, 'md' => 5, 'lg' => 5]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        $currentLocal = App::currentLocale();
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('invoice_number')->label(trans('sales.invoice_number'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('invoice_date')->label(trans('sales.invoice_date'))
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make($currentLocal == 'ar' ? 'partner.name_ar' : 'partner.name_en')->label(trans('partner.customer'))
                    ->searchable(),

                Tables\Columns\TextColumn::make('total')->label(trans('sales.total'))
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('vat')->label(trans('sales.vat'))
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('net_total')->label(trans('sales.net_total')),

                Tables\Columns\TextColumn::make('updated_at')->label(trans('material_request.last_update'))
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    // Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSellInvoices::route('/'),
            'create' => Pages\CreateSellInvoice::route('/create'),
            'view' => Pages\ViewSellInvoice::route('/{record}'),
            'edit' => Pages\EditSellInvoice::route('/{record}/edit'),
        ];
    }

    public static function setPriceVatLineTotal(Set $set, Get $get)
    {
        $itemId = $get('item_id');
        $quantity = $get('quantity');
        $price = $get('price');
        $discount = $get('discount');
        $vat = $get('vat');
        $itemId ? $set('price',  number_format(Items::find($itemId)->sale_price, 2)) : null;
        $price ? $set('vat', number_format($discount ? ($price - $discount) * 0.15 : $price * 0.15, 2)) : null;
        $quantity ? $set('line_total', number_format(($price + $vat - $discount) * $quantity, 2)) : null;

        // calc & set prinoive footer data
        $items = collect($get('../*'))
            ->filter(fn ($item) => !empty($item['item_id']) && !empty($item['quantity']) && !empty($item['price']));
        $set('../../sub_total', number_format($items->sum(fn ($item) => $item['price'] * $item['quantity']), 2));
        $set('../../discount', number_format($items->sum(fn ($item) => $item['discount'] * $item['quantity']), 2));
        $set('../../total', number_format($get('../../sub_total') - $get('../../discount'), 2));
        $set('../../vat', number_format($get('../../total') * 0.15, 2));
        $set('../../net_total', number_format($get('../../total') + $get('../../vat'), 2));
    }

    public static function getModelLabel(): string
    {
        return trans('sales.sell_invoice');
    }

    public static function getPluralModelLabel(): string
    {
        return trans('sales.sell_invoices');
    }

    public static function getNavigationGroup(): string
    {
        return trans('sales.sales');
    }
}
