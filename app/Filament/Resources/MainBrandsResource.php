<?php

namespace App\Filament\Resources;
use Illuminate\Support\Facades\App;

use App\Filament\Resources\MainBrandsResource\Pages;
use App\Filament\Resources\MainBrandsResource\RelationManagers;
use App\Models\MainBrands;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class MainBrandsResource extends Resource
{
    protected static ?string $model = MainBrands::class;

    protected static ?string $navigationIcon = 'heroicon-o-flag';
    protected static ?int $navigationSort = 3;


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
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
                Tables\Columns\TextColumn::make($currentLocal == 'ar' ?'name_ar':'name_en')->label(trans('shared.name'))
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\ViewAction::make(),

            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageMainBrands::route('/'),
        ];
    }

    public static function getModelLabel(): string{
        return trans('brands.main_brand');
    }
    public static function getPluralModelLabel(): string{
        return trans('brands.main_brands');
    }
    public static function getNavigationGroup(): string
    {
        return trans('stores.store_management');
    }
}
