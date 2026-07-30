<?php

namespace App\Filament\Resources\StockUnits;

use App\Filament\Resources\StockUnits\Pages\ManageStockUnits;
use App\Models\StockUnit;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use UnitEnum;
use Filament\Schemas\Components\Section;

class StockUnitResource extends Resource
{
    protected static string|UnitEnum|null $navigationGroup = 'Wharehouses';
    protected static ?string $model = StockUnit::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedVariable;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Stock Unit')
                ->columns(2)
                    ->components([
                        TextInput::make('name')
                            ->required(),
                        TextInput::make('symbol')
                            ->required(),
                    ])
                    ->columnSpanFull()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('symbol')
                    ->searchable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageStockUnits::route('/'),
        ];
    }
}
