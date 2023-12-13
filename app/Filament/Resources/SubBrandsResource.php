<?php

namespace App\Filament\Resources;
use Illuminate\Support\Facades\App;

use App\Filament\Resources\SubBrandsResource\Pages;
use App\Filament\Resources\SubBrandsResource\RelationManagers;
use App\Models\SubBrands;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SubBrandsResource extends Resource
{
    protected static ?string $model = SubBrands::class;

    protected static ?string $navigationIcon = 'heroicon-o-flag';
    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        $currentLocal = App::currentLocale();

        return $form
            ->schema([
                Forms\Components\Select::make('main_brand_id')
                ->relationship(name: 'mainBrand', titleAttribute:$currentLocal == 'ar' ?'name_ar':'name_en')->label(trans('brands.main_brand'))
                ->native(false)
                ->searchable()
                ->preload()
                    ->required(),
                Forms\Components\TextInput::make('name_ar')
                ->label(trans('shared.name_ar'))
                    ->required()
                    ->maxLength(25),
                Forms\Components\TextInput::make('name_en')
                ->label(trans('shared.name_en'))
                    ->required()
                    ->maxLength(25),
                Forms\Components\TextInput::make('code')
                ->label(trans('brands.code'))
                    ->required()
                    ->maxLength(10),
            ]);
    }

    public static function table(Table $table): Table
    {
        $currentLocal = App::currentLocale();
        return $table
            ->columns([
                Tables\Columns\TextColumn::make($currentLocal == 'ar' ?'mainBrand.name_ar':'mainBrand.name_en')->label(trans('brands.sub_brand'))
                    ->sortable(),
                Tables\Columns\TextColumn::make($currentLocal == 'ar' ?'name_ar':'name_en')->label(trans('shared.name'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('code')->label(trans('brands.code'))
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
            'index' => Pages\ManageSubBrands::route('/'),
        ];
    }

    public static function getModelLabel(): string{
        return trans('brands.sub_brand');
    }
    public static function getPluralModelLabel(): string{
        return trans('brands.sub_brands');
    }
    public static function getNavigationGroup(): string
    {
        return trans('stores.store_management');
    }
}