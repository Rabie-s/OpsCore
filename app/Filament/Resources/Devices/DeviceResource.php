<?php

namespace App\Filament\Resources\Devices;

use App\Filament\Resources\Devices\Pages\ManageDevices;
use App\Models\Counter;
use App\Models\Device;
use App\Models\DeviceType;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Forms\Components\Select;
use UnitEnum;
use Filament\Actions\Action;

class DeviceResource extends Resource
{

    protected static string|UnitEnum|null $navigationGroup = 'HR';
    protected static ?string $model = Device::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedComputerDesktop;

    protected static ?string $recordTitleAttribute = 'ip';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('ip'),
                TextInput::make('device_number')
                    ->required(),
                Select::make('counter_id')
                    ->label('counter')
                    ->options(
                        Counter::query()
                            ->with('department')
                            ->get()
                            ->pluck('label', 'id')
                    )
                    ->required()
                    ->searchable(),
                Select::make('device_type')
                    ->options(DeviceType::query()->pluck('name', 'id'))
                    ->required()
                    ->searchable(),
            ]);
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('ip')
                    ->placeholder('-'),
                TextEntry::make('device_number'),
                TextEntry::make('counter.label')
                    ->numeric(),
                TextEntry::make('deviceType.name')
                    ->numeric(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('ip')
            ->columns([
                TextColumn::make('ip')
                    ->searchable(),
                TextColumn::make('device_number')
                    ->searchable(),
                TextColumn::make('counter.label')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('deviceType.name')
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
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                DeleteBulkAction::make(),
            ])
            ->headerActions([
                Action::make('devicesReport')
                    ->label('تقرير الاجهزة')
                    ->url(fn() => route('devicesReport'))
                    ->icon('heroicon-o-document-text')
                    ->color('warning'),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageDevices::route('/'),
        ];
    }
}
