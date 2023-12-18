<?php

namespace App\Filament\Resources;

use Filament\Forms;

use Filament\Forms\Components\Repeater;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Actions\Action;
use Filament\Tables\Table;
use App\Models\MaterialRequest;
use Filament\Resources\Resource;
use Filament\Forms\Components\Grid;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\App;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Support\Contracts\HasLabel;
use App\Filament\Resources\MaterialRequestResource\Pages;

class MaterialRequestResource extends Resource
{
    protected static ?string $model = MaterialRequest::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        $currentLocal = App::currentLocale();
        // todo: if item duplicated increase the quantity

        return $form
            ->schema([
                Section::make('Request Details')
                    ->label(trans('material_request.request_details'))
                    ->schema([
                        Grid::make([
                            'sm' => 1,
                            'xl' => 2,
                        ])
                            ->schema(
                                [
                                    TextInput::make('order_number')->label(trans('material_request.order_number'))
//                                        ->required()
//                                        ->default(self::creteNewItemNumber())
                                        ->disabled()
                                        ->maxLength(20),

                                    TextInput::make('status')
                                        ->default('pending')
                                        ->label(trans('material_request.status'))
                                        ->disabled(true),
                                ]
                            ),
                        Grid::make([
                            'sm' => 1,
                            'md' => 2,
                            'lg' => 3
                        ])
                            ->schema(
                                [
                                    Forms\Components\DatePicker::make('request_date')->label(trans('material_request.request_date'))
                                        ->required()
                                        ->native(false),
                                    Forms\Components\Select::make('store_id')
                                        ->relationship(name: 'store', titleAttribute: $currentLocal == 'ar' ? 'name_ar' : 'name_en')->label(trans('stores.store'))
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
                                ]
                            ),
                    ]),

//                Section::make()
//                    ->schema([
                Repeater::make('requestLines')
                    ->label(trans('material_request.items'))
                    ->relationship()
                    ->schema([
                        Grid::make(['default' => 4])->schema([

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
                        ]),
                    ])
                    ->columns(1)->columnSpan('full'),
//                    ]),

                // Forms\Components\Select::make('status')->label(trans('material_request.status'))
                // ->options(Status::class)
                // ->native(false)
                // ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        $currentLocal = App::currentLocale();

        return $table
            ->columns([
                Tables\Columns\TextColumn::make('order_number')->label(trans('material_request.order_number'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('request_date')->label(trans('material_request.request_date'))
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')->label(trans('material_request.status'))
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'pending' => 'gray',
                        'pricing' => 'info',
                        'quotation' => 'warning',
                        'approved' => 'success',
                        'rejected' => 'danger',
                    }),
                Tables\Columns\TextColumn::make($currentLocal == 'ar' ? 'store.name_ar' : 'store.name_en')->label(trans('stores.store'))
                    ->searchable(),
                Tables\Columns\TextColumn::make($currentLocal == 'ar' ? 'employee.name_ar' : 'employee.name_en')->label(trans('material_request.employee'))
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('updated_at')->label(trans('material_request.last_update'))
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\Filter::make('pending')
                    ->label(trans('material_request.status') . ' ' . trans('material_request.pending'))
                    ->query(fn(Builder $query): Builder => $query->where('status', 'pending')),
                Tables\Filters\Filter::make('pricing')
                    ->label(trans('material_request.status') . ' ' . trans('material_request.pricing'))
                    ->query(fn(Builder $query): Builder => $query->where('status', 'pricing')),
                Tables\Filters\Filter::make('quotation')
                    ->label(trans('material_request.status') . ' ' . trans('material_request.quotation'))
                    ->query(fn(Builder $query): Builder => $query->where('status', 'quotation')),
                Tables\Filters\Filter::make('completed')
                    ->label(trans('material_request.status') . ' ' . trans('material_request.completed'))
                    ->query(fn(Builder $query): Builder => $query->where('status', 'completed')),
                Tables\Filters\Filter::make('rejected')
                    ->label(trans('material_request.status') . ' ' . trans('material_request.rejected'))
                    ->query(fn(Builder $query): Builder => $query->where('status', 'rejected')),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
                Action::make(trans('material_request.pricing'))
                    ->color('info')
                    ->requiresConfirmation()
                    ->modalHeading(trans('material_request.change_to') . ' ' . trans('material_request.pricing'))
                    ->action(function (MaterialRequest $record) {
                        $record->status = 'pricing';
                        $record->save();
                    })
                    ->visible(fn(MaterialRequest $record) => $record->status == 'pending'),
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
            'index' => Pages\ListMaterialRequests::route('/'),
            'create' => Pages\CreateMaterialRequest::route('/create'),
            'view' => Pages\ViewMaterialRequest::route('/{record}'),
            'edit' => Pages\EditMaterialRequest::route('/{record}/edit'),
        ];
    }

    public static function getModelLabel(): string
    {
        return trans('material_request.material_request');
    }

    public static function getPluralModelLabel(): string
    {
        return trans('material_request.material_requests');
    }

    public static function getNavigationGroup(): string
    {
        return trans('material_request.purchase_management');
    }
}


enum Status: string implements HasLabel
{
//    case Pending = 'pending';
//    case Approved = 'approved';
//    case Rejected = 'rejected';

    public function getLabel(): ?string
    {
        return $this->name;
    }


}
