<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PartnerResource\Pages;
use App\Filament\Resources\PartnerResource\RelationManagers;
use App\Models\Partners;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Contracts\HasLabel;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\App;

class PartnerResource extends Resource
{
    protected static ?string $model = Partners::class;

    protected static ?string $navigationIcon = 'heroicon-o-shield-exclamation';

    public static function form(Form $form): Form
    {
        $currentLocal = App::currentLocale();
        return $form
            ->schema([
                Forms\Components\TextInput::make('name_ar')->label(trans('shared.name_ar'))
                    ->required()
                    ->maxLength(25),
                Forms\Components\TextInput::make('name_en')->label(trans('shared.name_en'))
                    ->required()
                    ->maxLength(25),
                Forms\Components\Select::make('partner_type')->label(trans('partner.partner_type'))
                    ->options(PartnerType::class)
                    ->native(false)
                    ->required(),
                Forms\Components\Select::make('payment_type')->label(trans('partner.payment_type'))
                    ->options(PaymentType::class)
                    ->native(false)
                    ->required(),
                Forms\Components\TextInput::make('mobile')->label(trans('shared.mobile'))
                    ->tel()
                    ->required()
                    ->maxLength(20),
                Forms\Components\TextInput::make('email')->label(trans('shared.email'))
                    ->email()
                    ->required()
                    ->maxLength(150),
                Forms\Components\TextInput::make('credit_limit')->label(trans('partner.credit_limit'))
                    ->numeric()
                    ->minValue(0)
                    ->required(),
                Forms\Components\TextInput::make('credit_period')->label(trans('partner.credit_period'))
                    ->numeric()
                    ->minValue(0)
                    ->required(),
                Forms\Components\Select::make('country_id')
                    ->relationship(name: 'country', titleAttribute: $currentLocal == 'ar' ?'name_ar':'name_en')
                    ->label(trans('shared.country'))
                    ->searchable()
                    ->preload()
                    ->required()
                    ->native(false),
                Forms\Components\Select::make('employee_id')
                    ->relationship(name: 'employee', titleAttribute: $currentLocal == 'ar' ? 'name_ar' : 'name_en')->label(trans('material_request.employee'))
                    ->native(false)
                    ->searchable()
                    ->preload()
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        $currentLocal = App::currentLocale();
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->label(trans('shared.account_number'))
                    ->searchable(),
                Tables\Columns\TextColumn::make($currentLocal == 'ar' ?'name_ar':'name_en')->label(trans('shared.name'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('partner_type')->label(trans('partner.partner_type'))
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'supplier'=>'info',
                        'customer'=>'success',
                    })
                    ->searchable(),

            ])
            ->filters([
                Tables\Filters\Filter::make('supplier')
                    ->label( trans('partner.supplier'))
                    ->query(fn(Builder $query): Builder => $query->where('partner_type', 'supplier')),
                Tables\Filters\Filter::make('customer')
                    ->label( trans('partner.customer'))
                    ->query(fn(Builder $query): Builder => $query->where('partner_type', 'customer')),

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
            'index' => Pages\ListPartners::route('/'),
            'create' => Pages\CreatePartner::route('/create'),
            'view' => Pages\ViewPartner::route('/{record}'),
            'edit' => Pages\EditPartner::route('/{record}/edit'),
        ];
    }
    public static function getModelLabel(): string
    {
        return trans('partner.partner');
    }

    public static function getPluralModelLabel(): string
    {
        return trans('partner.partners');
    }

}

enum PartnerType: string implements HasLabel
{
    case Supplier = 'supplier';
    case Customer = 'customer';

    public function getLabel(): ?string
    {
        return $this->name;
    }
}

enum PaymentType: string implements HasLabel
{
    case Cash = 'cash';
    case Credit = 'credit';

    public function getLabel(): ?string
    {
        return $this->name;
    }
}
