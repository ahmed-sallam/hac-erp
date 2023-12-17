<?php

namespace App\Filament\Resources;
use Illuminate\Support\Facades\App;

use App\Filament\Resources\StoresResource\Pages;
use App\Filament\Resources\StoresResource\RelationManagers;
use App\Models\Stores;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;


class StoresResource extends Resource
{
    protected static ?string $model = Stores::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('city_ar')->label(trans('stores.city_ar'))
                    ->required()
                    ->maxLength(25),
                Forms\Components\TextInput::make('city_en')->label(trans('stores.city_en'))
                    ->required()
                    ->maxLength(25),
                Forms\Components\TextInput::make('name_ar')->label(trans('shared.name_ar'))
                    ->required()
                    ->maxLength(25),
                Forms\Components\TextInput::make('name_en')->label(trans('shared.name_en'))
                    ->required()
                    ->maxLength(25),
            ]);
    }

    public static function table(Table $table): Table
    {
        $currentLocal = App::currentLocale();
        return $table
            ->columns([

                Tables\Columns\TextColumn::make($currentLocal == 'ar' ?'city_ar':'city_en')->label(trans('stores.city'))
                    ->searchable(),
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
            'index' => Pages\ListStores::route('/'),
            'create' => Pages\CreateStores::route('/create'),
            'edit' => Pages\EditStores::route('/{record}/edit'),
        ];
    }
    public static function getModelLabel(): string{
        return trans('stores.store');
    }
    public static function getPluralModelLabel(): string{
        return trans('stores.stores');
    }
    public static function getNavigationGroup(): string
    {
        return trans('stores.store_management');
    }
}
