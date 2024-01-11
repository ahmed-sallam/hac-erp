<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Get;
use Filament\Forms\Form;
use App\Models\Employees;
use Filament\Tables\Table;
use App\Models\CustomerRequest;
use Filament\Resources\Resource;
use Filament\Forms\Components\Grid;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\RichEditor;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\CustomerRequestResource\Pages;
use Icetalker\FilamentTableRepeater\Forms\Components\TableRepeater;
use App\Filament\Resources\CustomerRequestResource\RelationManagers;

class CustomerRequestResource extends Resource
{
    protected static ?string $model = CustomerRequest::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?int $navigationSort = 0;


    public static function form(Form $form): Form
    {
        $currentLocal = App::currentLocale();
        return $form
            ->schema([
                TextInput::make('number')
                    ->label(trans('sales.request_number'))
                    ->disabled(),
                DatePicker::make('date')
                    ->label(trans('sales.request_date'))
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
                    ->required(),
                Select::make('employee_id')
                    ->relationship(name: 'employee', titleAttribute: $currentLocal == 'ar' ? 'name_ar' : 'name_en')
                    ->label(trans('material_request.employee'))
                    ->native(false)
                    ->searchable()
                    ->preload()
                    ->required(),
                RichEditor::make('notes')
                    ->label(trans('sales.notes'))->columnSpan(2),

                TableRepeater::make('requestLines')
                    ->label(trans('material_request.items'))
                    ->relationship('requestLines')
                    ->schema([
                        Select::make('item_id')
                            ->relationship(name: 'item', titleAttribute: 'item_number')
                            ->label(trans('material_request.item_number'))
                            ->getOptionLabelFromRecordUsing(
                                fn ($record) => "{$record->item_number} - {$record->mainBrand->name_ar} - {$record->subBrand->name_ar} - {$record->country->name_ar} "
                            )
                            ->searchable()
                            ->preload()
                            ->disableOptionWhen(function ($value, $state, Get $get) {
                                return collect($get('../*.item_id'))
                                    ->reject(fn ($id) => $id == $state)
                                    ->filter()
                                    ->contains($value);
                            })
                            ->required()
                            ->native(false),
                        TextInput::make('quantity')->label(trans('material_request.quantity'))
                            ->required()
                            ->minValue(1)
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
                    ->minItems(1)
                    ->columnSpanFull()
                    ->colStyles([
                        'item_id' => 'width: 50%;',
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        $currentLocal = App::currentLocale();
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('number')
                    ->searchable(),
                Tables\Columns\TextColumn::make($currentLocal == 'ar' ? 'partner.name_ar' : 'partner.name_en')
                    ->label(trans('partner.customer'))
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make($currentLocal == 'ar' ? 'employee.name_ar' : 'employee.name_en')
                    ->label(trans('material_request.employee'))
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                ]),
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
            'index' => Pages\ListCustomerRequests::route('/'),
            'create' => Pages\CreateCustomerRequest::route('/create'),
            'view' => Pages\ViewCustomerRequest::route('/{record}'),
            'edit' => Pages\EditCustomerRequest::route('/{record}/edit'),
        ];
    }
    public static function getModelLabel(): string
    {
        return trans('sales.customer_request');
    }

    public static function getPluralModelLabel(): string
    {
        return trans('sales.customer_requests');
    }
    public static function getNavigationGroup(): string
    {
        return trans('sales.sales');
    }
}
