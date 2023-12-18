<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PurchaseQuotationResource\Pages;
use App\Filament\Resources\PurchaseQuotationResource\RelationManagers;
use App\Models\PurchaseQuotation;
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

class PurchaseQuotationResource extends Resource
{
    protected static ?string $model = PurchaseQuotation::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        // todo: if item duplicated increase the quantity
        // todo: Get items from material request
        $currentLocal = App::currentLocale();
        return $form
            ->schema([
                Section::make(trans('purchase_quotation.quotation_details'))
//                    ->label(trans('purchase_quotation.quotation_details'))
                    ->schema([
                        Grid::make([
                            'sm' => 1,
                            'lg' => 3,
                        ])
                            ->schema(
                                [
                                    Forms\Components\Select::make('material_request_id')
                                        ->relationship(
                                            name: 'materialRequest',
                                            titleAttribute: 'order_number',
                                            modifyQueryUsing: fn(Builder $query)=>
                                            $query
                                                ->where('status', 'pending')
                                                ->orWhere('status', 'pricing')
                                        )->label(trans('material_request.order_number'))
                                        ->native(false)
                                        ->searchable()
                                        ->preload()
                                        ->required(),
                                    TextInput::make('quotation_number')->label(trans('purchase_quotation.quotation_number'))
                                        ->required()
                                        ->maxLength(20),
                                    TextInput::make('status')
                                        ->default('pending')
                                        ->label(trans('material_request.status'))
                                        ->disabled(true),
                                    Forms\Components\DatePicker::make('quotation_date')
                                        ->label(trans('purchase_quotation.quotation_date'))
                                        ->required()
                                        ->native(false),
                                    Forms\Components\Select::make('partner_id')
                                        ->relationship(name: 'partner', titleAttribute: $currentLocal == 'ar' ? 'name_ar' : 'name_en')->label(trans('partner.supplier'))
                                        ->native(false)
                                        ->searchable()
                                        ->preload()
                                        ->required(),
                                ]
                            ),
                    ]),
                Repeater::make('quotationLines')
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
//                                    ->getSearchResultsUsing(fn(string $search): array => Items::where('item_number', 'like', "%{$search}%"))
                                ->preload()
                                ->required()
                                ->native(false)->columnSpan(3),
                            TextInput::make('quantity')->label(trans('material_request.quantity'))
                                ->required()
                                ->minValue(1)
                                ->numeric()->columnSpan(1),
                            TextInput::make('price')->label(trans('purchase_quotation.price'))
                                ->required()
                                ->minValue(0)
                                ->numeric()->columnSpan(1),
                            TextInput::make('vat')->label(trans('purchase_quotation.vat'))
                                ->required()
                                ->minValue(0)
                                ->numeric()->columnSpan(1),
                        ]),
                    ])
                    ->columns(1)->columnSpan('full'),
            ]);
    }

    public static function table(Table $table): Table
    {
        $currentLocal = App::currentLocale();
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('materialRequest.order_number')->label(trans('material_request.order_number'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('quotation_number')->label(trans('purchase_quotation.quotation_number'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('quotation_date')->label(trans('purchase_quotation.quotation_date'))
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make($currentLocal == 'ar' ? 'partner.name_ar' : 'partner.name_en')->label(trans('partner.supplier'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')->label(trans('purchase_quotation.status'))
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'pending' => 'gray',
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
            'index' => Pages\ListPurchaseQuotations::route('/'),
            'create' => Pages\CreatePurchaseQuotation::route('/create'),
            'view' => Pages\ViewPurchaseQuotation::route('/{record}'),
            'edit' => Pages\EditPurchaseQuotation::route('/{record}/edit'),
        ];
    }

    public static function getModelLabel(): string
    {
        return trans('purchase_quotation.purchase_quotation');
    }

    public static function getPluralModelLabel(): string
    {
        return trans('purchase_quotation.purchase_quotations');
    }

    public static function getNavigationGroup(): string
    {
        return trans('material_request.purchase_management');
    }
}
