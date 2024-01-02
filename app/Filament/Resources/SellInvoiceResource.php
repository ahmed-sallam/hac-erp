<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SellInvoiceResource\Pages;
use App\Filament\Resources\SellInvoiceResource\RelationManagers;
use App\Models\SellInvoice;
use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\App;

class SellInvoiceResource extends Resource
{
    protected static ?string $model = SellInvoice::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        $currentLocal = App::currentLocale();

        return $form
            ->schema([
                Section::make(trans('sales.invoice_details'))
                    ->label(trans('sales.invoice_details'))
                    ->schema([
                        Grid::make([
                            'sm' => 1,
                            'xl' => 2,
                        ])
                            ->schema(
                                [
                                    TextInput::make('invoice_number')->label(trans('sales.invoice_number'))
                                        ->disabled()
                                        ->maxLength(20)->inlineLabel(),
                                    Forms\Components\DatePicker::make('invoice_date')->label(trans('sales.invoice_date'))
                                        ->required()
                                        ->date()
                                        ->native(false)->inlineLabel(),
                                    Forms\Components\DatePicker::make('delivery_date')->label(trans('sales.delivery_date'))
                                        ->required()
                                        ->date()
                                        ->native(false)->inlineLabel(),
                                    Forms\Components\Select::make('invoice_type')->label(trans('sales.invoice_type'))
                                        ->options([
                                            'cash' => 'cash',
                                            'credit' => 'credit'
                                        ])
                                        ->required()->inlineLabel(),
                                    Forms\Components\Select::make('partner_id')
                                        ->relationship(name: 'partner', titleAttribute: $currentLocal == 'ar' ? 'name_ar' : 'name_en')->label(trans('partner.customer'))
                                        ->native(false)
                                        ->searchable()
                                        ->preload()
                                        ->required()->inlineLabel(),
                                    Forms\Components\Select::make('sell_quotation_id')
                                        ->relationship(name: 'sellQuotation', titleAttribute: 'quotation_number')->label(trans('sales.quotation_number'))
                                        ->native(false)
                                        ->searchable()
                                        ->preload()
                                        ->inlineLabel(),
                                    TextInput::make('reference')->label(trans('sales.reference'))
                                        ->maxLength(20)->inlineLabel(),
                                ]
                            ),

                    ]),

                \Icetalker\FilamentTableRepeater\Forms\Components\TableRepeater::make('invoiceLines')
                    ->label(trans('material_request.items'))
                    ->relationship('invoiceLines')
                    ->schema([

                        Forms\Components\Select::make('item_id')
                            ->relationship(name: 'item', titleAttribute: 'item_number')
                            ->label(trans('material_request.item_number'))
                            ->getOptionLabelFromRecordUsing(
                                fn($record) => "{$record->item_number} // {$record->mainBrand->name_ar} // {$record->subBrand->name_ar} // {$record->country->name_ar} ")
                            ->searchable()
                            ->preload()
                            ->required()
                            ->native(false),
                        TextInput::make('quantity')->label(trans('material_request.quantity'))
                            ->required()
                            ->minValue(1)
                            ->numeric(),
                        TextInput::make('price')->label(trans('purchase_quotation.price'))
                            ->required()
                            ->minValue(0)
                            ->reactive()
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
                            ->required()
                            ->minValue(0)
                            ->numeric(),
                        TextInput::make('vat')->label(trans('purchase_quotation.vat'))
                            ->required()
                            ->minValue(0)
                            ->numeric(),

                    ])
                    ->collapsible()
                    ->minItems(1)
                    ->columnSpan('full')
                    ->colStyles([
                        'item_id' => 'width: 50%;',
                    ]),

                Section::make(trans('sales.invoice_value'))
                    ->label(trans('sales.invoice_value'))
                    ->schema([

                        Grid::make()->schema([
                            TextInput::make('sub_total')->label(trans('sales.sub_total'))
                                ->numeric()->minValue(0)->required(),
//                            ->afterStateUpdated(function($state, callable $set){
//                                dd($state);
////                                $set('vat', (int)$state * 0.15);
//                            }),
                            TextInput::make('discount')->label(trans('sales.discount'))
                                ->numeric()->minValue(0)->required(),
                            TextInput::make('vat')->label(trans('purchase_quotation.vat'))
                                ->numeric()->minValue(0)->required(),
                            TextInput::make('total')->label(trans('sales.total'))
                                ->numeric()->minValue(0)->required(),
                        ])->columns(['default' => 2, 'sm' => 2, 'lg' => 4]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
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
                    Tables\Actions\DeleteBulkAction::make(),
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
