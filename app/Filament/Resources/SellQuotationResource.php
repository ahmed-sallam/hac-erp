<?php
namespace App\Filament\Resources;
use App\Filament\Resources\SellQuotationResource\Pages;
use App\Filament\Resources\SellQuotationResource\RelationManagers;
use App\Models\SellQuotation;
use Awcodes\FilamentTableRepeater\Components\TableRepeater;
use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\App;
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
                Section::make(trans('sales.quotation_details'))
                    ->label(trans('sales.quotation_details'))
                    ->schema([
                        Grid::make([
                            'sm' => 1,
                            'xl' => 2,
                        ])
                            ->schema(
                                [
                                    TextInput::make('quotation_number')->label(trans('sales.quotation_number'))
                                        ->disabled()
                                        ->maxLength(20)->inlineLabel(),

                                    TextInput::make('status')
                                        ->default('under_process')
                                        ->label(trans('material_request.status'))
                                        ->disabled(true)->inlineLabel(),
                                    Forms\Components\DatePicker::make('quotation_date')->label(trans('sales.quotation_date'))
                                        ->required()
                                        ->native(false)->inlineLabel(),
                                    Forms\Components\Select::make('partner_id')
                                        ->relationship(name: 'partner', titleAttribute: $currentLocal == 'ar' ? 'name_ar' : 'name_en')->label(trans('partner.customer'))
                                        ->native(false)
                                        ->searchable()
                                        ->preload()
                                        ->required()->inlineLabel(),
                                ]
                            ),

                    ]),

                \Icetalker\FilamentTableRepeater\Forms\Components\TableRepeater::make('quotationLines')
                    ->label(trans('material_request.items'))
                    ->relationship('quotationLines')
                    ->schema([

                            Forms\Components\Select::make('item_id')
                                ->relationship(name: 'item', titleAttribute: 'item_number')
                                ->label(trans('material_request.item_number'))
                                ->getOptionLabelFromRecordUsing(
                                    fn($record) => "{$record->item_number} // {$record->mainBrand->name_ar} // {$record->subBrand->name_ar} // {$record->country->name_ar} ")
                                ->searchable()
                                ->preload()
                                ->required()
                                ->live(onBlur: true)
                                ->native(false),
                            TextInput::make('quantity')->label(trans('material_request.quantity'))
                                ->required()
                                ->minValue(1)
                                ->numeric(),
                            TextInput::make('price')->label(trans('purchase_quotation.price'))
                                ->required()
                                ->minValue(0)
                                ->reactive()
                                ->afterStateUpdated(function($state, callable $set){
                                    $set('vat', (int)$state * 0.15);
                                })
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

//                Repeater::make('quotationLines')
//                    ->label(trans('material_request.items'))
//                    ->relationship()
//                    ->schema([
//                        Grid::make(['default' => 6])->schema([
//
//                            Forms\Components\Select::make('item_id')
//                                ->relationship(name: 'item', titleAttribute: 'item_number')
//                                ->label(trans('material_request.item_number'))
//                                ->getOptionLabelFromRecordUsing(
//                                    fn($record) => "{$record->item_number} // {$record->mainBrand->name_ar} // {$record->subBrand->name_ar} // {$record->country->name_ar} ")
//                                ->searchable()
//                                ->preload()
//                                ->required()
//                                ->native(false)->columnSpan(3),
//                            TextInput::make('quantity')->label(trans('material_request.quantity'))
//                                ->required()
//                                ->minValue(1)
//                                ->numeric()->columnSpan(1),
//                            TextInput::make('price')->label(trans('purchase_quotation.price'))
//                                ->required()
//                                ->minValue(0)
//                                ->numeric()->columnSpan(1),
//                            TextInput::make('vat')->label(trans('purchase_quotation.vat'))
//                                ->required()
//                                ->minValue(0)
//                                ->numeric()->columnSpan(1),
//                        ])->extraAttributes(['class'=>'gap-0 ']),
//                    ])
//                    ->columns(1)->columnSpan('full'),
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
                    ->color(fn(string $state): string => match ($state) {
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
