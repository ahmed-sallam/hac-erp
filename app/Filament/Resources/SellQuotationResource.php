<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Items;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\SellQuotation;
use App\Models\CustomerRequest;
use Filament\Resources\Resource;
use App\Models\CustomerRequestLine;
use Illuminate\Support\Facades\App;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\RichEditor;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\SellQuotationResource\Pages;
use Awcodes\FilamentTableRepeater\Components\TableRepeater;
use App\Filament\Resources\SellQuotationResource\RelationManagers;

class SellQuotationResource extends Resource
{
    protected static ?string $model = SellQuotation::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        $currentLocal = App::currentLocale();
        return $form
            ->schema([
                TextInput::make('quotation_number')->label(trans('sales.quotation_number'))
                    ->disabled(),
                TextInput::make('status')
                    ->default('under_process')
                    ->label(trans('material_request.status'))
                    ->disabled(),
                Select::make('customer_request_id')
                    ->relationship(
                        name: 'customerRequest',
                        titleAttribute: 'number'
                    )
                    ->label(trans('sales.customer_request'))
                    ->native(false)
                    ->searchable()
                    ->live()
                    ->afterStateUpdated(function ($state, Set $set, Get $get) {
                        self::updateRequestItems($state, $set, $get);
                    })
                    ->preload(),
                DatePicker::make('quotation_date')->label(trans('sales.quotation_date'))
                    ->date()
                    ->required()
                    ->native(false),
                Select::make('partner_id')
                    ->relationship(
                        name: 'partner',
                        titleAttribute: $currentLocal == 'ar' ? 'name_ar' : 'name_en',
                        modifyQueryUsing: fn (Builder $query) => $query->where('partner_type', '=', 'customer')
                    )
                    ->label(trans('partner.customer'))
                    ->native(false)
                    ->searchable()
                    ->preload()
                    // ->disabled(fn (Get $get) => $get('customer_request_id') ? true : false)
                    ->disableOptionWhen(fn (Get $get) => $get('customer_request_id') ? true : false)
                    ->selectablePlaceholder(
                        fn (Get $get) => $get('customer_request_id') ? true : false
                    )
                    ->required(),
                Select::make('employee_id')
                    ->relationship(name: 'employee', titleAttribute: $currentLocal == 'ar' ? 'name_ar' : 'name_en')
                    ->label(trans('material_request.employee'))
                    ->native(true)
                    ->searchable()
                    ->preload()
                    ->required(),

                RichEditor::make('notes')
                    ->label(trans('sales.notes'))->columnSpan(2),
                \Icetalker\FilamentTableRepeater\Forms\Components\TableRepeater::make('quotationLines')
                    ->label(trans('material_request.items'))
                    ->relationship('quotationLines')
                    ->schema([
                        Select::make('item_id')
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
                            ->required()
                            ->live()
                            ->afterStateUpdated(function ($state, Set $set, Get $get) {
                                $state ? $set('price',  Items::find($state)->sale_price) : null; //////
                            })
                            ->native(false),
                        TextInput::make('quantity')->label(trans('material_request.quantity'))
                            ->required()
                            ->minValue(1)
                            ->numeric(),
                        TextInput::make('price')->label(trans('purchase_quotation.price'))
                            ->reactive()
                            ->readOnly()
                            ->numeric(),
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
                    ])
                    // ->addable(fn (Get $get) => !$get('customer_request_id'))
                    ->minItems(1)
                    ->columnSpanFull()
                    ->colStyles([
                        'item_id' => 'width: 40%;',
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        $currentLocal = App::currentLocale();

        return $table
            ->columns([

                Tables\Columns\TextColumn::make('quotation_number')->label(trans('sales.quotation_number'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('quotation_date')->label(trans('sales.quotation_date'))
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make($currentLocal == 'ar' ? 'partner.name_ar' : 'partner.name_en')->label(trans('partner.customer'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')->label(trans('purchase_quotation.status'))
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'under_process' => 'gray',
                        'completed' => 'success',
                        'rejected' => 'danger',
                    }),

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
                //                Tables\Actions\BulkActionGroup::make([
                //                    Tables\Actions\DeleteBulkAction::make(),
                //                ]),
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
            'index' => Pages\ListSellQuotations::route('/'),
            'create' => Pages\CreateSellQuotation::route('/create'),
            'view' => Pages\ViewSellQuotation::route('/{record}'),
            'edit' => Pages\EditSellQuotation::route('/{record}/edit'),
        ];
    }


    public static function updateRequestItems($state, Set $set, Get $get)
    {
        if ($state) {

            $lines = CustomerRequestLine::where('customer_request_id',  $state)->get()->map(function ($item) {
                return [
                    'item_id' => $item['item_id'],
                    'quantity' => $item['quantity'],
                    'price' =>  Items::find($item['item_id'])->sale_price,
                    'store_id' => $item['store_id'],
                ];
            });
            $set('partner_id', CustomerRequest::find($state)->partner_id);
            $set('quotationLines', [...$lines]);
        }
    }

    public static function getModelLabel(): string
    {
        return trans('sales.sell_quotation');
    }

    public static function getPluralModelLabel(): string
    {
        return trans('sales.sell_quotations');
    }

    public static function getNavigationGroup(): string
    {
        return trans('sales.sales');
    }
}
