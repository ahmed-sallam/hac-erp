<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StockMovementResource\Pages;
use App\Filament\Resources\StockMovementResource\RelationManagers;
use App\Models\StockMovement;
use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Contracts\HasLabel;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\App;

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
                Section::make(trans('stock.movement_details'))
                    ->label(trans('stock.movement_details'))
                    ->schema([
                        Grid::make([
                            'sm' => 1,
                            'xl' => 2,
                        ])
                            ->schema(
                                [
                                     Forms\Components\Select::make('movement_type')->label(trans('stock.movement_type'))
                                     ->options(MovementType::class)
                                     ->native(false)
                                     ->required(),
                                    Forms\Components\Select::make('source_store_id')
                                        ->relationship(name: 'sourceStore', titleAttribute:
                                            $currentLocal == 'ar' ? 'name_ar' : 'name_en')->label(trans('stock.source_store'))
                                        ->native(false)
                                        ->searchable()
                                        ->preload()
                                        ->required(),
                                    Forms\Components\Select::make('destination_store_id')
                                        ->relationship(name: 'destinationStore', titleAttribute:
                                            $currentLocal == 'ar' ? 'name_ar' : 'name_en')->label(trans('stock.destination_store'))
                                        ->native(false)
                                        ->searchable()
                                        ->preload()
                                        ->required(),
                                    Forms\Components\Select::make('employee_id')
                                        ->relationship(name: 'employee', titleAttribute:
                                            $currentLocal == 'ar' ? 'name_ar' : 'name_en')->label(trans('material_request.employee'))
                                        ->native(false)
                                        ->searchable()
                                        ->preload()
                                        ->required(),
                                    Forms\Components\DatePicker::make('movement_date')->label(trans('stock.movement_date'))
                                        ->required()
                                        ->native(false),
                                    TextInput::make('reference')->label(trans('stock.reference'))
                                        ->maxLength(20),
                                ]
                            ),

                    ]),

                \Icetalker\FilamentTableRepeater\Forms\Components\TableRepeater::make('movementLines')
                    ->label(trans('material_request.items'))
                    ->relationship('movementLines')
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
                    ])
                    ->collapsible()
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
                'sourceStore.name_ar': 'sourceStore.name_en')->label(trans('stock.source_store')),
            Tables\Columns\TextColumn::make($currentLocal == 'ar' ?
                'destinationStore.name_ar': 'destinationStore.name_en')->label(trans('stock.destination_store')),
            Tables\Columns\TextColumn::make($currentLocal == 'ar' ?
                'employee.name_ar': 'employee.name_en')->label(trans('material_request.employee')),
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

    public static function getModelLabel(): string{
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
    case In = 'in';
    case Out = 'out';
    case Transfer = 'transfer';


    public function getLabel(): ?string
    {
        return $this->name;
    }


}
