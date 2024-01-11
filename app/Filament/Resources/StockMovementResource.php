<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Get;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\StockMovement;
use Filament\Resources\Resource;
use Filament\Forms\Components\Grid;
use Illuminate\Support\Facades\App;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Support\Contracts\HasLabel;
use Filament\Forms\Components\RichEditor;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\StockMovementResource\Pages;
use App\Filament\Resources\StockMovementResource\RelationManagers;

class StockMovementResource extends Resource
{
    protected static ?string $model = StockMovement::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?int $navigationSort = 5;


    public static function form(Form $form): Form
    {
        $currentLocal = App::currentLocale();
        return $form
            ->schema([
                Forms\Components\Select::make('movement_type')->label(trans('stock.movement_type'))
                    ->options(MovementType::class)
                    ->native(false)
                    ->required(),
                Forms\Components\Select::make('source_store_id')
                    ->relationship(name: 'sourceStore', titleAttribute: $currentLocal == 'ar' ? 'name_ar' : 'name_en')->label(trans('stock.source_store'))
                    ->disableOptionWhen(function ($value, $state, Get $get) {
                        return collect($get('destination_store_id'))
                            ->reject(fn ($id) => $id == $state)
                            ->filter()
                            ->contains($value);
                    })
                    ->native(false)
                    ->searchable()
                    ->preload()
                    ->required(),
                Forms\Components\Select::make('destination_store_id')
                    ->relationship(name: 'destinationStore', titleAttribute: $currentLocal == 'ar' ? 'name_ar' : 'name_en')->label(trans('stock.destination_store'))
                    ->disableOptionWhen(function ($value, $state, Get $get) {
                        return collect($get('source_store_id'))
                            ->reject(fn ($id) => $id == $state)
                            ->filter()
                            ->contains($value);
                    })
                    ->native(false)
                    ->searchable()
                    ->preload()
                    ->required(),
                Forms\Components\Select::make('employee_id')
                    ->relationship(name: 'employee', titleAttribute: $currentLocal == 'ar' ? 'name_ar' : 'name_en')->label(trans('material_request.employee'))
                    ->native(false)
                    ->searchable()
                    ->preload()
                    ->required(),
                Forms\Components\DatePicker::make('movement_date')->label(trans('stock.movement_date'))
                    ->required()
                    ->native(false),
                TextInput::make('reference')->label(trans('stock.reference'))
                    ->maxLength(20),

                RichEditor::make('notes')
                    ->label(trans('sales.notes'))->columnSpan(2),


                \Icetalker\FilamentTableRepeater\Forms\Components\TableRepeater::make('movementLines')
                    ->label(trans('material_request.items'))
                    ->relationship('movementLines')
                    ->schema([

                        Forms\Components\Select::make('item_id')
                            ->relationship(name: 'item', titleAttribute: 'item_number')
                            ->label(trans('material_request.item_number'))
                            ->getOptionLabelFromRecordUsing(
                                fn ($record) => "{$record->item_number} // {$record->mainBrand->name_ar} // {$record->subBrand->name_ar} // {$record->country->name_ar} "
                            )
                            ->searchable()
                            ->preload()
                            ->required()
                            ->native(false),
                        TextInput::make('quantity')->label(trans('material_request.quantity'))
                            ->required()
                            ->minValue(1)
                            ->numeric(),
                    ])
                    ->minItems(1)
                    ->columnSpan('full')
                    ->colStyles([
                        'item_id' => 'width: 75%; ',
                    ]),




            ]);
    }

    public static function table(Table $table): Table
    {
        $currentLocal = App::currentLocale();
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id'),
                Tables\Columns\TextColumn::make('movement_date')->label(trans('stock.movement_date'))
                    ->date(),
                Tables\Columns\TextColumn::make('movement_type')->label(trans('stock.movement_type')),
                Tables\Columns\TextColumn::make($currentLocal == 'ar' ?
                    'sourceStore.name_ar' : 'sourceStore.name_en')->label(trans('stock.source_store')),
                Tables\Columns\TextColumn::make($currentLocal == 'ar' ?
                    'destinationStore.name_ar' : 'destinationStore.name_en')->label(trans('stock.destination_store')),
                Tables\Columns\TextColumn::make($currentLocal == 'ar' ?
                    'employee.name_ar' : 'employee.name_en')->label(trans('material_request.employee')),
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
            'index' => Pages\ListStockMovements::route('/'),
            'create' => Pages\CreateStockMovement::route('/create'),
            'view' => Pages\ViewStockMovement::route('/{record}'),
            'edit' => Pages\EditStockMovement::route('/{record}/edit'),
        ];
    }

    public static function getModelLabel(): string
    {
        return trans('stock.stock_movement');
    }

    public static function getPluralModelLabel(): string
    {
        return trans('stock.stock_movement');
    }
    public static function getNavigationGroup(): string
    {
        return trans('stores.store_management');
    }
}

enum MovementType: string implements HasLabel
{
    case Sale = 'sale';
    case SaleReturn = 'sale_return';
    case Purchase = 'purchase';
    case PurchaseReturn = 'purchase_return';
    case Scrap = 'scrap';
    case Transfer = 'transfer';


    public function getLabel(): ?string
    {
        return $this->name;
    }
}

// todo: addvalidation on selceted stores when do specific operation (sale, purchase,.....)

//todo: add balance validation
// todo:add dynamic reference