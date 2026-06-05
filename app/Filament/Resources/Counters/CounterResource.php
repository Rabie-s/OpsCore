<?php

namespace App\Filament\Resources\Counters;

use App\Filament\Resources\Counters\Pages\ManageCounters;
use App\Models\Counter;
use App\Models\Department;
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
use Filament\Forms\Components\Select;
use Filament\Tables\Table;
use UnitEnum;
class CounterResource extends Resource
{

    protected static string | UnitEnum | null $navigationGroup = 'HR';
    protected static ?string $model = Counter::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCalculator;

    protected static ?string $recordTitleAttribute = 'counter_number';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('counter_number')
                    ->required()
                    ->numeric(),
                Select::make('department_id')
                    ->label('Depatment')
                    ->options(Department::query()->pluck('name', 'id'))
                    ->required()
                    ->searchable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('counter_number')
            ->columns([
                TextColumn::make('counter_number')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('department.name')
                    ->numeric()
                    ->sortable(),
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
            'index' => ManageCounters::route('/'),
        ];
    }
}
