<?php

namespace App\Filament\Resources;
use Illuminate\Support\Facades\App;

use App\Filament\Resources\StoreLocationsResource\Pages;
use App\Filament\Resources\StoreLocationsResource\RelationManagers;
use App\Models\StoreLocations;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class StoreLocationsResource extends Resource
{
    protected static ?string $model = StoreLocations::class;

    protected static ?string $navigationIcon = 'heroicon-o-map-pin';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        $currentLocal = App::currentLocale();
        // ddd($currentLocal);
        return $form
            ->schema([
                Forms\Components\Select::make('store_id')
                ->relationship(name: 'store', titleAttribute:$currentLocal == 'ar' ?'name_ar':'name_en')->label(trans('stores.store'))
                    // ->relationship(name: trans('stores.store'), titleAttribute : $currentLocal == 'ar' ?'name_ar':'name_en')
                    ->native(false)
                    ->searchable()
                    ->preload()
                    ->required(),
                Forms\Components\TextInput::make('name_ar')->label(trans('shared.name_ar'))
                    ->required()
                    ->maxLength(10),
                Forms\Components\TextInput::make('name_en')->label(trans('shared.name_en'))
                    ->required()
                    ->maxLength(10),
            ]);
    }

    public static function table(Table $table): Table
    {
        $currentLocal = App::currentLocale();

        return $table
            ->columns([
                Tables\Columns\TextColumn::make($currentLocal == 'ar' ?'store.name_ar':'store.name_en')->label(trans('stores.store'))
                    ->sortable(),
                Tables\Columns\TextColumn::make($currentLocal == 'ar' ?'name_ar':'name_en')->label(trans('shared.name'))
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),

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
            'index' => Pages\ListStoreLocations::route('/'),
            'create' => Pages\CreateStoreLocations::route('/create'),
            'edit' => Pages\EditStoreLocations::route('/{record}/edit'),
        ];
    }

    public static function getModelLabel(): string{
        return trans('stores.store_location');
    }
    public static function getPluralModelLabel(): string{
        return trans('stores.store_locations');
    }

    public static function getNavigationGroup(): string
    {
        return trans('stores.store_management');
    }
}