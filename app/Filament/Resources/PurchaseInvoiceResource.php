<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PurchaseInvoiceResource\Pages;
use App\Filament\Resources\PurchaseInvoiceResource\RelationManagers;
use App\Models\PurchaseInvoice;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Contracts\HasLabel;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\App;

class PurchaseInvoiceResource extends Resource
{
    protected static ?string $model = PurchaseInvoice::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        $currentLocal = App::currentLocale();
        return $form
            ->schema([
                Section::make('Request Details')
                    ->label(trans('material_request.request_details'))
                    ->schema([
                        Grid::make([
                            'sm' => 1,
                            'md' => 2,
                            'lg' => 3
                        ])
                            ->schema(
                                [
                                    TextInput::make('invoice_number')
                                        ->label(trans('purchase_quotation.invoice_number'))
                                        ->required()
                                        ->maxLength(20),
                                    DatePicker::make('invoice_date')
                                        ->label(trans('purchase_quotation.invoice_date'))
                                        ->required()
                                        ->native(false),
                                    Select::make('invoice_type')
                                        ->label(trans('purchase_quotation.invoice_type'))
                                        ->options(InvoiceType::class)
                                        ->native(false)
                                        ->required(),
                                    TextInput::make('discount')
                                        ->label(trans('purchase_quotation.discount'))
                                        ->numeric()
                                        ->disabled()
                                        ->required(),
                                    Select::make('partner_id')
                                        ->relationship(name: 'partner', titleAttribute: $currentLocal == 'ar' ? 'name_ar' : 'name_en')->label(trans('partner.supplier'))
                                        ->searchable()
                                        ->preload()
                                        ->required()
                                        ->native(false),
                                    TextInput::make('sub_total')
                                        ->label(trans('purchase_quotation.sub_total'))
                                        ->numeric()
                                        ->disabled()
                                        ->required(),
                                    TextInput::make('vat')
                                        ->label(trans('purchase_quotation.vat'))
                                        ->numeric()
                                        ->disabled()
                                        ->required(),
                                    TextInput::make('total')
                                        ->label(trans('purchase_quotation.total'))
                                        ->numeric()
                                        ->disabled()
                                        ->required(),
                                ]
                            ),
                    ]),
                Section::make(trans('stock.stock_movement'))
                    ->schema([
                        DatePicker::make('delivery_date')
                            ->label(trans('purchase_quotation.delivery_date'))
                            ->required()
                            ->native(false),
                        Select::make('store_employee_id')
                            ->relationship(name: 'storeEmployee', titleAttribute: $currentLocal == 'ar' ? 'name_ar' : 'name_en')
                            ->label(trans('material_request.employee'))
                            ->native(false)
                            ->searchable()
                            ->preload()
                            ->required(),
                    ])->columns(2),
                Repeater::make('purchaseInvoiceLines')
                    ->label(trans('material_request.items'))
                    ->relationship()
                    ->schema([
                        Grid::make(['default' => 6])->schema([

                            Forms\Components\Select::make('item_id')
                                ->relationship(name: 'item', titleAttribute: 'item_number')
                                ->label(trans('material_request.item_number'))
                                ->getOptionLabelFromRecordUsing(
                                    fn($record) => "{$record->item_number} // {$record->mainBrand->name_ar} // {$record->subBrand->name_ar} // {$record->country->name_ar} ")
                                ->searchable()
                                ->preload()
                                ->required()
                                ->native(false)->columnSpan(2),
                            TextInput::make('quantity')->label(trans('material_request.quantity'))
                                ->required()
                                ->minValue(1)
                                ->numeric()->columnSpan(1),
                            TextInput::make('price')->label(trans('purchase_quotation.price'))
                                ->required()
                                ->minValue(0)
                                ->numeric()->columnSpan(1),
                            TextInput::make('discount')->label(trans('purchase_quotation.discount'))
                                ->required()
                                ->minValue(0)
                                ->numeric()->columnSpan(1),
                            TextInput::make('vat')->label(trans('purchase_quotation.vat'))
                                ->required()
                                ->minValue(0)
                                ->numeric()->columnSpan(1),
                        ])->extraAttributes(['class'=>'gap-0']),
                    ])
                    ->columns(1)->columnSpan('full'),
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
            'index' => Pages\ListPurchaseInvoices::route('/'),
            'create' => Pages\CreatePurchaseInvoice::route('/create'),
            'view' => Pages\ViewPurchaseInvoice::route('/{record}'),
            'edit' => Pages\EditPurchaseInvoice::route('/{record}/edit'),
        ];
    }

    public static function getModelLabel(): string
    {
        return trans('purchase_quotation.purchase_invoice');
    }

    public static function getPluralModelLabel(): string
    {
        return trans('purchase_quotation.purchase_invoices');
    }

    public static function getNavigationGroup(): string
    {
        return trans('material_request.purchase_management');
    }
}

enum InvoiceType: string implements HasLabel
{
    case Cash = 'cash';
    case Credit = 'credit';

    public function getLabel(): ?string
    {
        return $this->name;
    }


}
