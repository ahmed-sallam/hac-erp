<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StoresResource\Pages;
use App\Filament\Resources\StoresResource\RelationManagers;
use App\Models\Stores;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class StoresResource extends Resource
{
    protected static ?string $model = Stores::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('city_ar')
                    ->required()
                    ->maxLength(25),
                Forms\Components\TextInput::make('city_en')
                    ->required()
                    ->maxLength(25),
                Forms\Components\TextInput::make('name_ar')
                    ->required()
                    ->maxLength(25),
                Forms\Components\TextInput::make('name_en')
                    ->required()
                    ->maxLength(25),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('city_ar')
                    ->searchable(),
                Tables\Columns\TextColumn::make('city_en')
                    ->searchable(),
                Tables\Columns\TextColumn::make('name_ar')
                    ->searchable(),
                Tables\Columns\TextColumn::make('name_en')
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
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
            'index' => Pages\ListStores::route('/'),
            'create' => Pages\CreateStores::route('/create'),
            'edit' => Pages\EditStores::route('/{record}/edit'),
        ];
    }
}
